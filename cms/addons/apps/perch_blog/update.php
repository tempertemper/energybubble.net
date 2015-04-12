<?php
    // Prevent running directly:
    if (!defined('PERCH_DB_PREFIX')) exit;
    
    $db = $API->get('DB');
    
    $sql = "SHOW INDEX FROM `".PERCH_DB_PREFIX."blog_posts` WHERE Key_name = 'idx_search'";
    $result = $db->get_row($sql);
    if (PerchUtil::count($result)==0) {
        $sql = "ALTER TABLE `".PERCH_DB_PREFIX."blog_posts` ADD FULLTEXT idx_search (`postTitle`, `postDescRaw`, `postTags`)";
        $db->execute($sql);
    }

    $sql = "ALTER TABLE `".PERCH_DB_PREFIX."blog_posts` ADD COLUMN `postDynamicFields` text AFTER `postDescHTML`";
    $db->execute($sql);

    $sql = "ALTER TABLE `".PERCH_DB_PREFIX."blog_posts` ADD COLUMN `postStatus` enum('Published','Draft') NOT NULL DEFAULT 'Published' AFTER `postTags`";
    $db->execute($sql);

    
    $Posts = new PerchBlog_Posts;
    $posts = $Posts->all();

    if (PerchUtil::count($posts)) {
        $FirstPost = $posts[0];
        if (!$FirstPost->postStatus()) {
            
            $sql = "ALTER TABLE `".PERCH_DB_PREFIX."blog_posts` ADD COLUMN `postDynamicFields` text AFTER `postDescHTML`";
            $db->execute($sql);

            $sql = "ALTER TABLE `".PERCH_DB_PREFIX."blog_posts` ADD COLUMN `postStatus` enum('Published','Draft') NOT NULL DEFAULT 'Published' AFTER `postTags`";
            $db->execute($sql);
            
            $posts = $Posts->all();
            
            // fix up dynamic fields
            if (PerchUtil::count($posts)) {
                foreach($posts as $Post) {
                    $dynamic_fields = PerchUtil::json_safe_decode($Post->postDynamicFields(), true);

                    $changed = false;

                    if (is_array($dynamic_fields)) {
                        foreach($dynamic_fields as $key=>$val) {
                            if (substr($key, -4)!='_raw') {
                                if (!array_key_exists($key.'_raw', $dynamic_fields)) {
                                    $dynamic_fields[$key.'_raw'] = $val;
                                    $changed = true;
                                }
                            }
                        }
                    }

                    if ($changed) {
                        $data = array();
                        $data['postDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);
                        $Post->update($data, false, false);
                    }

                }
            }
            
        }
    }
    
    $message = $HTML->warning_message('Install complete. Please delete the file: <code>%s</code>', $API->app_path().'/update.php');  

?>