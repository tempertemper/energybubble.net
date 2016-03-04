<?php

  perch_layout('global/header');

  perch_blog_recent_posts(10);

  perch_blog_date_archive_years();
  perch_blog_categories();
  perch_blog_tags();

  perch_layout('global/footer');