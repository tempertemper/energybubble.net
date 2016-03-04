<?php

  perch_layout('global/header');

  echo '<main role="main">';
  echo '<h1>';
  perch_content('Main heading');
  echo '</h1>';

  perch_content('Primary content');

  perch_blog_recent_posts(10);

  perch_blog_categories();
  perch_blog_tags();
  perch_blog_date_archive_years();

  echo '</main>';

  perch_layout('global/footer');