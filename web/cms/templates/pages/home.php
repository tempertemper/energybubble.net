<?php
  perch_layout('global/header', [
    'body-class' => 'home',
  ]);
?>

<main role="main">

  <h1>
    <?php perch_content('Main heading'); ?>
  </h1>

  <?php perch_content('Primary content'); ?>

  <?php
    perch_blog_recent_posts(10);

    perch_blog_categories();
    perch_blog_tags();
    perch_blog_date_archive_years();
  ?>

</main>

<?php perch_layout('global/footer'); ?>