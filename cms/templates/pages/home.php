<?php

  perch_layout('global/header', [
    'body-class' => 'home',
  ]);

  perch_content('Primary content');

  perch_blog_recent_posts(10);

  perch_blog_categories();
  perch_blog_tags();
  perch_blog_date_archive_years();

  perch_layout('global/footer');
