<?php include('cms/runtime.php');?>

<!DOCTYPE html>
<html xml:lang="en" lang="en">

<head>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="keywords" content="energybubble, positive passion" />
<meta name="description" content="<?php perch_content('Description'); ?>" />

<title>energybubble &#8226; Archive</title>

<link href="rss.php" rel="alternate" type="application/rss+xml" title="RSS" />

<link href="css/global.css" rel="stylesheet" media="screen" />
<link href="css/print.css" rel="stylesheet" media="print" />

<?php perch_content('Analytics'); ?>

</head>


<body class="archive">

	<div class="wrap">

		<div class="main">

			<header>
				<h1><a href="/">energybubble</a></h1>
			</header>

			<div class="content">

				<section>
				<?php perch_content('Introduction'); ?>
					<?php 
					    
					    // Default mode
					    $mode = 'date';
					    $date_from  = date('Y-01-01');
					    $date_to    = date('Y-12-31');
					    
					    
					    // Category?
					    if (perch_get('cat')) {
					        $mode = 'category';
					        $categorySlug = perch_get('cat');
					        $categoryTitle = perch_blog_category($categorySlug, true);
					        echo '<h2>'.$categoryTitle.'</h2>';
					    }
					    
					    // Tag?
					    if (perch_get('tag')) {
					        $mode = 'tag';
					        $tagSlug = perch_get('tag');
					    }
					    
					    // Year?
					    if (perch_get('year')) {
					        $mode = 'date';
					        $year = intval(perch_get('year'));
					        $date_from  = $year.'-01-01';
					        $date_to    = $year.'-12-31';
					        
					        
					        // Month and Year?
					        if (perch_get('month')) {
					            $month = intval(perch_get('month'));
					            $date_from  = $year.'-'.$month.'-01';
					            $date_to    = $year.'-'.$month.'-31';
					        }
					    }
					    
					    switch($mode) 
					    {
					        case 'category':
					            $opts = array(
					                'category'=>$categorySlug
					                );
					            break;
					            
					        case 'tag':
					            $opts = array(
					                'tag'=>$tagSlug
					                );
					            break;
					            
					        case 'date':
					            $opts = array(
					                'filter'=>'postDateTime',
					                'match'=>'eqbetween',
					                'value'=>$date_from.','.$date_to
					                );
					            break;
					    }
					    
					    $opts['count'] = 10000;
					    $opts['sort'] = 'postDateTime';
					    $opts['sort-order'] = 'DESC';
					    $opts['template'] = 'blog/archive_post_in_list.html';
					    
					    perch_blog_custom($opts);
					?>
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