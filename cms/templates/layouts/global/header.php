<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php perch_pages_title(); ?></title>
	<?php perch_page_attributes(); ?>
	<?php perch_get_css(); ?>
</head>
<?php
	if (perch_layout_has('body-class')) {
		echo '<body class="'.perch_layout_var('body-class', true).'">';
	}else{
		echo '<body>';
	}
?>

<header role="banner">

  <a href="/" class="logo">
    <img src="<?php perch_path('feathers/energybubble/img/energybubble-logo.png'); ?>" alt="energybubble logo" />
  </a>

  <h1>
    <?php perch_content('Main heading'); ?>
  </h1>

</header>