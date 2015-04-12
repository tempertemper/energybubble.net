<?php

  perch_layout('global/header');

  perch_content('Main heading');

  perch_pages_navigation([
    'hide-extensions'=>true,
    'hide-default-doc'=>true,
    'levels'=>1,
  ]);

  perch_blog_recent_posts(10);

  perch_blog_categories();
  perch_blog_tags();
  perch_blog_date_archive_years();

  perch_layout('global/footer');