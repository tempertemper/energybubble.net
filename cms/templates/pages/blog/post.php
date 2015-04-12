<?php

  perch_layout('blog/post_header');

  perch_blog_post(perch_get('s'));

  perch_blog_author_for_post(perch_get('s'));

  perch_blog_post_categories(perch_get('s'));
  perch_blog_post_tags(perch_get('s'));

  perch_blog_categories();
  perch_blog_tags();
  perch_blog_date_archive_years();

  perch_layout('global/footer');
