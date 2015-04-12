<?php

    PerchSystem::register_search_handler('PerchBlog_SearchHandler');

    require('PerchBlog_Posts.class.php');
    require('PerchBlog_Post.class.php');
    require('PerchBlog_Categories.class.php');
    require('PerchBlog_Category.class.php');
    require('PerchBlog_Comments.class.php');
    require('PerchBlog_Comment.class.php');
    require('PerchBlog_Tags.class.php');
    require('PerchBlog_Tag.class.php');
    require('PerchBlog_Authors.class.php');
    require('PerchBlog_Author.class.php');
    require('PerchBlog_Cache.class.php');
    require('PerchBlog_SearchHandler.class.php');


    function perch_blog_form_handler($SubmittedForm)
    {
        if ($SubmittedForm->formID=='comment' && $SubmittedForm->validate()) {
            $API  = new PerchAPI(1.0, 'perch_blog');
            $Comments = new PerchBlog_Comments($API);
            $Comments->receive_new_comment($SubmittedForm);
        }
        $Perch = Perch::fetch();
        PerchUtil::debug($Perch->get_form_errors($SubmittedForm->formID));
        
    }

    
    function perch_blog_recent_posts($count=10, $return=false) 
    {
        $opts = array(
                'count'=>$count,
                'template'=>'blog/post_in_list.html',
                'sort'=>'postDateTime',
                'sort-order'=>'DESC'
            );

        $r = perch_blog_custom($opts, $return);
    	if ($return) return $r;
    	echo $r;
    }
    
    function perch_blog_post($id_or_slug, $return=false)
    {
        $opts = array(
            'template'=>'blog/post.html'
            );

        if (is_numeric($id_or_slug)) {
            $opts['_id'] = intval($id_or_slug);            
        }else{
            $opts['filter'] = 'postSlug';
            $opts['match']  = 'eq';
            $opts['value']  = $id_or_slug;
        }
        
        $r = perch_blog_custom($opts, $return);
        if ($return) return $r;
        echo $r;
    }


    /**
     * Get the comments for a specific post
     * @param  string  $id_or_slug   ID or slug for the post
     * @param  array $opts=false   Options
     * @param  boolean $return=false Return or output
     */
    function perch_blog_post_comments($id_or_slug, $opts=false, $return=false)
    {
        $API  = new PerchAPI(1.0, 'perch_blog');   

        $defaults = array();
        $defaults['template']        = 'comment.html';
        $defaults['count']           = false;
        $defaults['sort']            = 'commentDateTime';
        $defaults['sort-order']      = 'ASC';
        $defaults['paginate']        = false;
        $defaults['pagination-var']  = 'comments';

        if (is_array($opts)) {
            $opts = array_merge($defaults, $opts);
        }else{
            $opts = $defaults;
        }

        $postID = false;

        if (is_numeric($id_or_slug)) {
            $postID = intval($id_or_slug);            
        }else{
            $BlogPosts = new PerchBlog_Posts($API);
            $Post = $BlogPosts->find_by_slug($id_or_slug);
            if (is_object($Post)) {
                $postID = $Post->id();
            }
        }


        $Comments = new PerchBlog_Comments($API);

        $r = $Comments->get_custom($postID, $opts);

        if ($return) return $r;

        echo $r;
    }
    
    function perch_blog_post_comment_form($id_or_slug, $opts=false, $return=false)
    {
        $API  = new PerchAPI(1.0, 'perch_blog'); 

        $defaults = array();
        $defaults['template']        = 'comment_form.html';

        if (is_array($opts)) {
            $opts = array_merge($defaults, $opts);
        }else{
            $opts = $defaults;
        }


        $postID = false;

        if (is_numeric($id_or_slug)) {
            $postID = intval($id_or_slug);            
        }else{
            $BlogPosts = new PerchBlog_Posts($API);
            $Post = $BlogPosts->find_by_slug($id_or_slug);
            if (is_object($Post)) {
                $postID = $Post->id();
            }
        }

        $Template = $API->get('Template');
        $Template->set('blog/'.$opts['template'], 'blog');
        $html = $Template->render(array('postID'=>$postID));
        $html = $Template->apply_runtime_post_processing($html);
        
        if ($return) return $html;
        echo $html;


    }

    /**
     * 
     * Get the content of a specific field
     * @param mixed $id_or_slug the id or slug of the post
     * @param string $field the name of the field you want to return
     * @param bool $return
     */
    function perch_blog_post_field($id_or_slug, $field, $return=false)
    {
        $API  = new PerchAPI(1.0, 'perch_blog');
        $BlogPosts = new PerchBlog_Posts($API);
        
        $r = false;
        
        if (is_numeric($id_or_slug)) {
            $postID = intval($id_or_slug);
            $Post = $BlogPosts->find($postID);
        }else{
            $Post = $BlogPosts->find_by_slug($id_or_slug);
        }
        
        $encode = true;

        if (is_object($Post)) {
            $field = $Post->$field();
            if (is_array($field)) {
                if (isset($field['_default'])) {
                    $r = $field['_default'];
                }elseif (isset($field['processed'])) {
                    $r = $field['processed'];
                    $encode = false;
                }else{
                    $r = $field;
                }
            }else{
                $r = $field;
            }
        }
        
        if ($return) return $r;
        
        if ($encode) {
            $HTML = $API->get('HTML');
            echo $HTML->encode($r);
        }else{
            echo $r;
        }
        
    }
	
    /**
     * 
     * Gets the categories used for a post to display 
     * @param string $id_or_slug id or slug of the current post
     * @param string $template template to render the categories
     * @param bool $return if set to true returns the output rather than echoing it
     */
    function perch_blog_post_categories($id_or_slug, $template='post_category_link.html',$return=false)
    {
        $API  = new PerchAPI(1.0, 'perch_blog');
        $BlogPosts = new PerchBlog_Posts($API);
        
        $postID = false;
        
        if (is_numeric($id_or_slug)) {
            $postID = intval($id_or_slug); 
        }else{
            $Post = $BlogPosts->find_by_slug($id_or_slug);
            if (is_object($Post)) {
                $postID = $Post->id();
            }
        }
        
        if ($postID!==false) {
            $Categories = new PerchBlog_Categories();
            $cats   = $Categories->get_for_post($postID);
            
            $Template = $API->get('Template');
            $Template->set('blog/'.$template, 'blog');

            $r = $Template->render_group($cats, true);
            
            if ($return) return $r;
            echo $r;
        }
        
        return false;
    }
	
    /**
     * 
     * Gets the tags used for a post to display 
     * @param string $id_or_slug id or slug of the current post
     * @param string $template template to render the tags
     * @param bool $return if set to true returns the output rather than echoing it
     */
    function perch_blog_post_tags($id_or_slug, $template='post_tag_link.html',$return=false)
    {
        $API  = new PerchAPI(1.0, 'perch_blog');
        $BlogPosts = new PerchBlog_Posts($API);
        
        $postID = false;
        
        if (is_numeric($id_or_slug)) {
            $postID = intval($id_or_slug); 
        }else{
            $Post = $BlogPosts->find_by_slug($id_or_slug);
            if (is_object($Post)) {
                $postID = $Post->id();
            }
        }
        
        if ($postID!==false) {
            $Tags = new PerchBlog_Tags();
            $tags   = $Tags->get_for_post($postID);
            
            $Template = $API->get('Template');
            $Template->set('blog/'.$template, 'blog');

            $r = $Template->render_group($tags, true);
            
            if ($return) return $r;
            echo $r;
        }
        
        return false;
    }
    
    function perch_blog_custom($opts=false, $return=false)
    {
        if (isset($opts['skip-template']) && $opts['skip-template']==true) $return = true; 
        
        $API  = new PerchAPI(1.0, 'perch_blog');
        
        $BlogPosts = new PerchBlog_Posts($API);
        
        $r = $BlogPosts->get_custom($opts);
        
    	if ($return) return $r;
    	
    	echo $r;
    }
    
    /**
     * 
     * Builds an archive listing of categories. Echoes out the resulting mark-up and content
     * @param string $template
     * @param bool $return if set to true returns the output rather than echoing it
     */
    function perch_blog_categories($template='category_link.html', $return=false)
    {
        $API  = new PerchAPI(1.0, 'perch_blog');
        $BlogPosts = new PerchBlog_Posts($API);
        
        $Categories = new PerchBlog_Categories();
        $cats       = $Categories->all_in_use();
        
        $Template = $API->get('Template');
        $Template->set('blog/'.$template, 'blog');

        $r = $Template->render_group($cats, true);
        
        if ($return) return $r;
        echo $r;
        
        return false;
    }
    
    /**
     * Gets the title of a category from its slug
     *
     * @param string $categorySlug 
     * @param string $return 
     * @return void
     * @author Drew McLellan
     */
    function perch_blog_category($categorySlug, $return=false)
    {
        $API  = new PerchAPI(1.0, 'perch_blog');
        $Categories = new PerchBlog_Categories($API);
        
        $Category = $Categories->find_by_slug($categorySlug);
        
        if (is_object($Category)){
            $r = $Category->categoryTitle();
            if ($return) return $r;
            echo $r;
        }
        
        return false;
    }
    
    /**
     * 
     * Builds an archive listing of tags. Echoes out the resulting mark-up and content
     * @param string $template
     * @param bool $return if set to true returns the output rather than echoing it
     */
    function perch_blog_tags($template='tag_link.html', $return=false)
    {
        $API  = new PerchAPI(1.0, 'perch_blog');
        $BlogPosts = new PerchBlog_Posts($API);
    
        $Tags = new PerchBlog_Tags();
        $tags   = $Tags->all_in_use();
        
        $Template = $API->get('Template');
        $Template->set('blog/'.$template, 'blog');

        $r = $Template->render_group($tags, true);
        
        if ($return) return $r;
        echo $r;
        
        return false;
    }
    
    /**
     * 
     * Builds an archive listing looping through years. Echoes out the resulting mark-up and content
     * @param string $template
     * @param bool $return if set to true returns the output rather than echoing it
     */
    function perch_blog_date_archive_years($template='year_link.html', $return=false)
    {
    	$API  = new PerchAPI(1.0, 'perch_blog');
        $BlogPosts = new PerchBlog_Posts($API);
        
        $years = $BlogPosts->get_years();
        
        $Template = $API->get('Template');
        $Template->set('blog/'.$template, 'blog');

        $r = $Template->render_group($years, true);
        
        if ($return) return $r;
        echo $r;
        
        return false;
    }
    
    /**
     * 
     * Builds an archive listing looping through years then months in years. Echoes out the resulting mark-up and content
     * @param string $template_year - the template for the year loop
     * @param string $template_months - template for months loop
     * @param bool $return if set to true returns the output rather than echoing it
     */
    function perch_blog_date_archive_months($template_year='months_year_link.html', $template_months='months_month_link.html', $return=false)
    {
    	$API  = new PerchAPI(1.0, 'perch_blog');
        $BlogPosts = new PerchBlog_Posts($API);
        
        $Template = $API->get('Template');
        
        $years = $BlogPosts->get_years();
        /* loop through the years */
        for($i=0; $i<sizeOf($years);$i++) {
        	$months = $BlogPosts->get_months_for_year($years[$i]['year']);
        	$Template->set('blog/'.$template_months, 'blog');
        	/* render the months into the months template*/
        	$m = $Template->render_group($months, true);
        	/* add this rendered mark-up to the $years array */
        	$years[$i]['months'] = $m;
        }
        
        
        $Template->set('blog/'.$template_year, 'blog');
		/* render the $years array into the years template*/
        $r = $Template->render_group($years, true);
        
        if ($return) return $r;
        echo $r;
        
        return false;
    }

?>