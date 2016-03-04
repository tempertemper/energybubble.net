<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php perch_blog_post_field(perch_get('s'), 'postTitle'); ?></title>

  <?php perch_page_attributes(); ?>
  <?php perch_get_css(); ?>
</head>

<body class="h-entry">

  <header role="banner">
    <a href="/" class="logo">
      <?php perch_layout('global/_logo'); ?>
    </a>

  <h1><?php perch_blog_post_field(perch_get('s'), 'postTitle'); ?></h1>

  </header>