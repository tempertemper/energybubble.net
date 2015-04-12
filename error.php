<?php include('cms/runtime.php');?>

<!DOCTYPE html>
<html xml:lang="en" lang="en">

<head>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="keywords" content="energybubble, positive passion" />
<meta name="description" content="<?php perch_content('Description'); ?>" />

<title>energybubble &#8226; Error 404 &#8226; Page not found</title>

<link href="rss.php" rel="alternate" type="application/rss+xml" title="RSS" />

<link href="css/global.css" rel="stylesheet" media="screen" />
<link href="css/print.css" rel="stylesheet" media="print" />

<?php perch_content('Analytics'); ?>

</head>


<body class="error">

	<div class="wrap">

		<div class="main">

			<header>
				<h1><a href="/">energybubble</a></h1>
			</header>

			<div class="content">

				<section>
					<h2>404 Error</h2>
					<p>You've requested a page that has been removed, changed or doesn't exist.</p>
					<p>Please return to the page you were on using the 'back' button in your browser.</p>
					<p>Alternatively, <a href="/">click here to return to the homepage<a/>.</p>
				</section><!--feed-->

		    	<aside>
					<div class="rss"><a href="rss.php">RSS</a></div>
		    		<div class="archive"><?php perch_blog_date_archive_months(); ?></div>
				</aside>

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
