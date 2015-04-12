<?php

  perch_layout('global/header');

  perch_content('Main heading');

  perch_pages_navigation([
    'hide-extensions'=>true,
    'hide-default-doc'=>true,
    'levels'=>1,
  ]);


  perch_blog_post(perch_get('s'));

  perch_blog_author_for_post(perch_get('s'));

  perch_blog_post_categories(perch_get('s'));
  perch_blog_post_tags(perch_get('s'));

  perch_blog_post_comments(perch_get('s'));
  perch_blog_post_comment_form(perch_get('s'));

  perch_blog_categories();
  perch_blog_tags();
  perch_blog_date_archive_years();

  perch_layout('global/footer');
