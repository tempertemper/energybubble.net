<?php

  perch_layout('blog/post_header');

  echo '<main role="main">';

  perch_blog_post(perch_get('s'));

  perch_blog_date_archive_years();

  perch_layout('global/footer');
