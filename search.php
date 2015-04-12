<?php include('cms/runtime.php');?>

<!DOCTYPE html>
<html xml:lang="en" lang="en">

<head>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="keywords" content="energybubble, positive passion" />
<meta name="description" content="<?php perch_content('Description'); ?>" />

<title>energybubble &#8226; Search results</title>

<link href="rss.php" rel="alternate" type="application/rss+xml" title="RSS" />

<link href="css/global.css" rel="stylesheet" media="screen" />
<link href="css/print.css" rel="stylesheet" media="print" />

<?php perch_content('Analytics'); ?>

</head>


<body class="search">

	<div class="wrap">

		<div class="main">

			<header>
				<h1><a href="/">energybubble</a></h1>
			</header>

			<section>
				<?php 
					$query = perch_get('q');
					perch_content_search($query); 
				?>
    		</section>

		</div><!--main-->

	</div><!--wrap-->

	<footer>
		<p>&copy; energybubble 2012 &#8226; Site designed by <a href="http://tempertemper.net/" target="_blank">TemperTemper Web Design</a></p>
	</footer>

</body>
</html>