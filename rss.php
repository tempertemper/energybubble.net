<?php include('cms/runtime.php');
	header('Content-Type: application/rss+xml');
	echo '<'.'?xml version="1.0"?'.'>'; 
?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>energybubble</title>

<link href="rss.php" rel="alternate" type="application/rss+xml" title="RSS" />
		<link>http://energybubble.net/</link>
		<description>energybubble is a blog about one person's spiritual journey.</description>
		<atom:link href="http://energybubble.net/rss.php" rel="self" type="application/rss+xml" />
		<?php
			$opts = array(
				'template'=>'blog/rss_post.html',
				'count'=>10,
				'sort'=>'postDateTime',
				'sort-order'=>'DESC'
				);

			perch_blog_custom($opts);
		?>
	</channel>
</rss>