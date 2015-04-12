<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php perch_blog_post_field(perch_get('s'), 'postTitle'); ?></title>

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
    <a href="/blog/">Blog</a>: <?php perch_blog_post_field(perch_get('s'), 'postTitle'); ?>
  </h1>

</header>