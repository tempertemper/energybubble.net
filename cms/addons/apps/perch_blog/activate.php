<?php
    // Prevent running directly:
    if (!defined('PERCH_DB_PREFIX')) exit;

    // Let's go
    $sql = "
    CREATE TABLE IF NOT EXISTS `__PREFIX__blog_authors` (
      `authorID` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `authorGivenName` varchar(255) NOT NULL DEFAULT '',
      `authorFamilyName` varchar(255) NOT NULL DEFAULT '',
      `authorEmail` varchar(255) NOT NULL DEFAULT '',
      `authorSlug` varchar(255) NOT NULL DEFAULT '',
      PRIMARY KEY (`authorID`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    CREATE TABLE IF NOT EXISTS `__PREFIX__blog_categories` (
      `categoryID` int(11) NOT NULL AUTO_INCREMENT,
      `categoryTitle` varchar(255) NOT NULL DEFAULT '',
      `categorySlug` varchar(255) NOT NULL DEFAULT '',
      PRIMARY KEY (`categoryID`),
      KEY `idx_slug` (`categorySlug`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

    CREATE TABLE IF NOT EXISTS `__PREFIX__blog_comments` (
      `commentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `postID` int(10) unsigned NOT NULL,
      `commentName` varchar(255) NOT NULL DEFAULT '',
      `commentEmail` varchar(255) NOT NULL DEFAULT '',
      `commentURL` varchar(255) NOT NULL DEFAULT '',
      `commentIP` int(10) unsigned NOT NULL,
      `commentDateTime` datetime NOT NULL,
      `commentHTML` text NOT NULL,
      `commentStatus` enum('LIVE','PENDING','SPAM','REJECTED') NOT NULL DEFAULT 'PENDING',
      `commentSpamData` text NOT NULL,
      `commentDynamicFields` text NOT NULL,
      PRIMARY KEY (`commentID`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

    CREATE TABLE IF NOT EXISTS `__PREFIX__blog_posts` (
      `postID` int(11) NOT NULL AUTO_INCREMENT,
      `postTitle` varchar(255) NOT NULL DEFAULT '',
      `postSlug` varchar(255) NOT NULL DEFAULT '',
      `postDateTime` datetime DEFAULT NULL,
      `postDescRaw` text,
      `postDescHTML` text,
      `postDynamicFields` text,
      `postTags` varchar(255) NOT NULL DEFAULT '',
      `postStatus` enum('Published','Draft') NOT NULL DEFAULT 'Published',
      `authorID` int(10) unsigned NOT NULL DEFAULT '0',
      PRIMARY KEY (`postID`),
      KEY `idx_date` (`postDateTime`),
      FULLTEXT KEY `idx_search` (`postTitle`,`postDescRaw`,`postTags`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

    CREATE TABLE IF NOT EXISTS `__PREFIX__blog_posts_to_categories` (
      `postID` int(11) NOT NULL DEFAULT '0',
      `categoryID` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`postID`,`categoryID`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

    CREATE TABLE IF NOT EXISTS `__PREFIX__blog_posts_to_tags` (
      `postID` int(11) NOT NULL DEFAULT '0',
      `tagID` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`postID`,`tagID`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

    CREATE TABLE IF NOT EXISTS `__PREFIX__blog_tags` (
      `tagID` int(11) NOT NULL AUTO_INCREMENT,
      `tagTitle` varchar(255) NOT NULL DEFAULT '',
      `tagSlug` varchar(255) NOT NULL DEFAULT '',
      PRIMARY KEY (`tagID`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
    ";
    
    $sql = str_replace('__PREFIX__', PERCH_DB_PREFIX, $sql);
    
    $statements = explode(';', $sql);
    foreach($statements as $statement) {
        $statement = trim($statement);
        if ($statement!='') $this->db->execute($statement);
    }
 
   
    $API = new PerchAPI(1.0, 'perch_blog');
    $UserPrivileges = $API->get('UserPrivileges');
    $UserPrivileges->create_privilege('perch_blog', 'Access the blog');
    $UserPrivileges->create_privilege('perch_blog.post.create', 'Create posts');
    $UserPrivileges->create_privilege('perch_blog.post.delete', 'Delete posts');
    $UserPrivileges->create_privilege('perch_blog.post.publish', 'Publish posts');
    $UserPrivileges->create_privilege('perch_blog.comments.moderate', 'Moderate comments');
    $UserPrivileges->create_privilege('perch_blog.categories.manage', 'Manage categories');
    
        
    $sql = 'SHOW TABLES LIKE "'.$this->table.'"';
    $result = $this->db->get_value($sql);
    
    return $result;

?>