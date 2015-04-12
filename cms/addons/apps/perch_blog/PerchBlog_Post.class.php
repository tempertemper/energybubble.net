<?php

class PerchBlog_Post extends PerchAPI_Base
{
    protected $table  = 'blog_posts';
    protected $pk     = 'postID';

    public $Template = false;

    private $tmp_url_vars = array();

    private $Author = false;

    public function __call($method, $arguments)
	{
		if (isset($this->details[$method])) {
			return $this->details[$method];
		}else{

            // check for Author details
            if (substr($method, 0, 6)=='author') {
                if (!$this->Author) {
                    $this->_load_author();
                }
                if (is_object($this->Author)) {
                    return $this->Author->$field();    
                }
            }

            // look in dynamic fields
            $dynamic_fields = PerchUtil::json_safe_decode($this->postDynamicFields(), true);
            if (isset($dynamic_fields[$method])) {
                return $dynamic_fields[$method];
            }

            // try database
		    PerchUtil::debug('Looking up missing property ' . $method, 'notice');
		    if (isset($this->details[$this->pk])){
		        $sql    = 'SELECT ' . $method . ' FROM ' . $this->table . ' WHERE ' . $this->pk . '='. $this->db->pdb($this->details[$this->pk]);
		        $this->details[$method] = $this->db->get_value($sql);
		        return $this->details[$method];
		    }
		}
		
		return false;
	}

    public function update($data, $do_cats=true, $do_tags=true)
    {
        PerchUtil::debug($data);

        $PerchBlog_Posts = new PerchBlog_Posts();
        
        if (isset($data['postDescRaw'])) {
            if (is_object($this->Template)) {
                $data['postDescHTML'] = $PerchBlog_Posts->text_to_html($data['postDescRaw'], $this->Template->find_tag('postDescHTML'));
            }else{
                $data['postDescHTML'] = $PerchBlog_Posts->text_to_html($data['postDescRaw']);
            }
            
        }
        

        if (isset($data['cat_ids'])) {
            $catIDs = $data['cat_ids'];
            unset($data['cat_ids']);
        }else{
            $catIDs = false;
        }

        // Update the post itself
        parent::update($data);

        // slug
        if (isset($data['postTitle'])) {
            $API  = new PerchAPI(1.0, 'perch_blog');
            $Settings = $API->get('Settings');
            $format = $Settings->get('perch_blog_slug_format')->val();
            if (!$format) {
                $format = '%Y-%m-%d-{postTitle}';
            }
            $this->tmp_url_vars = $this->details;
            $slug = preg_replace_callback('/{([A-Za-z0-9_\-]+)}/', array($this, "substitute_url_vars"), $format);

            $data['postSlug'] = strtolower(strftime($slug, strtotime($data['postDateTime'])));
            parent::update($data);
        }



        if ($do_cats) {
            // Delete existing categories
            $this->db->delete(PERCH_DB_PREFIX.'blog_posts_to_categories', $this->pk, $this->id());

     		// Add new categories
     		if (is_array($catIDs)) {
     			for($i=0; $i<sizeOf($catIDs); $i++) {
     			    $tmp = array();
     			    $tmp['postID'] = $this->id();
     			    $tmp['categoryID'] = $catIDs[$i];
     			    $this->db->insert(PERCH_DB_PREFIX.'blog_posts_to_categories', $tmp);
     			}
     		}
        }
        
        
        if ($do_tags) {
    		// Delete existing tags
    		$this->db->delete(PERCH_DB_PREFIX.'blog_posts_to_tags', $this->pk, $this->id());
		
    		// Split tag string into array
    		if($data['postTags'] != '') {
    			$a = explode(',',$data['postTags']);
    			if (is_array($a)) {
     				for($i=0; $i<sizeOf($a); $i++) {
    					$tmp = array();
    					$tmp['postID'] = $this->id();
    					$tag_str = trim($a[$i]);
    					//does this tag exist
    					$sql = 'SELECT tagID, tagTitle FROM '.PERCH_DB_PREFIX.'blog_tags WHERE tagTitle = '.$this->db->pdb($tag_str).' LIMIT 1';
					
    					$row = $this->db->get_row($sql);
					
					
    					if(is_array($row)) {
    						$tmp['tagID'] = $row['tagID'];
    					}else{
    						$tag = array();
    						$tag['tagTitle'] = $tag_str;
    						$tag['tagSlug'] = PerchUtil::urlify($tag_str);
    						$tmp['tagID'] = $this->db->insert(PERCH_DB_PREFIX.'blog_tags', $tag);
    					}
 			    	
     			    	$this->db->insert(PERCH_DB_PREFIX.'blog_posts_to_tags', $tmp);
     				}
     			}
    		}
    	}
    	
 		return true;
    }
    
    public function delete()
    {
        parent::delete();
        $this->db->delete(PERCH_DB_PREFIX.'blog_posts_to_categories', $this->pk, $this->id());
    }
    
    public function date()
    {
        return date('Y-m-d', strtotime($this->postDateTime()));
    }

    public function to_array()
    {
        $out = parent::to_array();

        if (!$this->Author) $this->_load_author();
        if (is_object($this->Author)) {
            $out = array_merge($out, $this->Author->to_array());
        }
        
        $Categories = new PerchBlog_Categories();
        $cats   = $Categories->get_for_post($this->id());
        
        $out['category_slugs'] = '';
        $out['category_names'] = '';
        
        if (PerchUtil::count($cats)) {
            $slugs = array();
            $names = array();
            foreach($cats as $Category) {
                $slugs[] = $Category->categorySlug();
                $names[] = $Category->categoryTitle();
                
                // for template
                $out[$Category->categorySlug()] = true;
            }
            
            $out['category_slugs'] = implode(' ', $slugs);
            $out['category_names'] = implode(', ', $names);
        }
        
        if ($out['postDynamicFields'] != '') {
            $dynamic_fields = PerchUtil::json_safe_decode($out['postDynamicFields'], true);
            if (PerchUtil::count($dynamic_fields)) {
                foreach($dynamic_fields as $key=>$value) {
                    $out['perch_'.$key] = $value;
                }
            }
            $out = array_merge($dynamic_fields, $out);
        }
        
        return $out;
    }

    private function substitute_url_vars($matches)
    {
        $url_vars = $this->tmp_url_vars;
        if (isset($url_vars[$matches[1]])){
            return PerchUtil::urlify($url_vars[$matches[1]]);
        }
    }
    
    private function _load_author()
    {
        $Authors = new PerchBlog_Authors;
        $this->Author = $Authors->find($this->authorID());
    }

}

?>