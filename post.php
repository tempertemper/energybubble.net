<?php include('cms/runtime.php');?>

<!DOCTYPE html>
<html xml:lang="en" lang="en">

<head>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="keywords" content="energybubble, positive passion" />
<meta name="description" content="<?php perch_content('Description'); ?>" />

<title>energybubble &#8226; Article</title>

<link href="rss.php" rel="alternate" type="application/rss+xml" title="RSS" />

<link href="css/global.css" rel="stylesheet" media="screen" />
<link href="css/print.css" rel="stylesheet" media="print" />

<?php perch_content('Analytics'); ?>

</head>


<body class="article">

	<div class="wrap">

		<div class="main">

			<header>
				<h1><a href="/">energybubble</a></h1>
			</header>

			<div class="content">

				<section>
				    <div class="post">
					    <?php perch_blog_post(perch_get('s')); ?>
					    <?php perch_blog_post_comments(perch_get('s'), array(
					        	'count'=>10
					    )); ?>
					    <div class="comments-form">
						    <h2>Leave a comment:</h2>
						    <?php perch_blog_post_comment_form(perch_get('s')); ?>
					    </div>
					    <div class="actions">
					    	<h2>Or:</h2>
					    	<ul>
					    		<li><a href="http://twitter.com/home?status=I just read an article about <?php perch_blog_post_field($_GET['s'], 'postTitle'); ?>: http://energybubble.net/<?php perch_blog_post_field($_GET['s'], 'postSlug'); ?>">Tweet this article</a></li>
					    		<li><a href="/archive">Browse the archives</a></li>
					    		<li><a href="/rss">Subscribe via RSS</a></li>
					    		<li><a href="/about">Learn a little bit more about me</a></li>
					    		<li><a href="/">Head back to the home page</a></li>
					    	</ul>
					    </div>
				    </div>
				</section>

			</div><!--content-->

		</div><!--main-->

	</div><!--wrap-->

	<footer>
	    <?php
    	    $query = perch_get('q');
    	    perch_content_search($query);
        ?>
		<p>&copy; energybubble 2012 &#8226; Site designed by <a href="http://tempertemper.net/" target="_blank">TemperTemper Web Design</a></p>
	</footer>

</body>
</html>