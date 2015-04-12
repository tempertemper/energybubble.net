<?php

  perch_layout('global/header');

  perch_content('Main heading');

  perch_pages_navigation([
    'hide-extensions'=>true,
    'hide-default-doc'=>true,
    'levels'=>1,
  ]);

  $posts_per_page = 10;
  $template     = 'post_in_list.html';
  $sort_order   = 'DESC';
  $sort_by    = 'postDateTime';

  $posts_displayed = false;


  /* --------------------------- POSTS BY CATEGORY --------------------------- */
  if (perch_get('cat')) {
    echo '<h1>Archive of: '.perch_blog_category(perch_get('cat'), true).'</h1>';

    perch_blog_custom(array(
      'category'   => perch_get('cat'),
      'template'   => $template,
      'count'      => $posts_per_page,
      'sort'       => $sort_by,
      'sort-order' => $sort_order,
    ));

    $posts_displayed = true;
  }

  /* --------------------------- POSTS BY TAG --------------------------- */
  if (perch_get('tag')) {
    echo '<h1>Archive of: '.perch_blog_tag(perch_get('tag'), true).'</h1>';

    perch_blog_custom(array(
      'tag'      => perch_get('tag'),
      'template'   => $template,
      'count'      => $posts_per_page,
      'sort'       => $sort_by,
      'sort-order' => $sort_order,
    ));

    $posts_displayed = true;
  }

  /* --------------------------- POSTS BY DATE RANGE --------------------------- */
  if (perch_get('year')) {

    $year              = intval(perch_get('year'));
    $date_from         = $year.'-01-01 00:00:00';
    $date_to           = $year.'-12-31 23:59:59';
    $title_date_format = '%Y';


    // Month and Year?
    if (perch_get('month')) {
      $month             = intval(perch_get('month'));
      $date_from         = $year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT).'-01 00:00:00';
      $date_to           = $year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT).'-31 23:59:59';
      $title_date_format = '%B, %Y';
    }

    echo '<h1>Archive of: '.strftime($title_date_format, strtotime($date_from)).'</h1>';

    perch_blog_custom(array(
      'filter'     => 'postDateTime',
      'match'      => 'eqbetween',
      'value'      => $date_from.','.$date_to,
      'template'   => $template,
      'count'      => $posts_per_page,
      'sort'       => $sort_by,
      'sort-order' => $sort_order,
    ));

    $posts_displayed = true;
  }

  /* --------------------------- POSTS BY AUTHOR --------------------------- */
  if (perch_get('author')) {

    echo '<h1>Posts by '.perch_blog_author(perch_get('author'), array(
                        'template' => 'author_name.html',
                        ), true).'</h1>';

    perch_blog_custom(array(
      'author'     => perch_get('author'),
      'template'   => $template,
      'count'      => $posts_per_page,
      'sort'       => $sort_by,
      'sort-order' => $sort_order,
    ));

    $posts_displayed = true;
  }

  /* --------------------------- DEFAULT: ALL POSTS --------------------------- */

  if ($posts_displayed == false) {

    echo '<h1>Archive</h1>';

    perch_blog_custom(array(
      'template'   => $template,
      'count'      => $posts_per_page,
      'sort'       => $sort_by,
      'sort-order' => $sort_order,
    ));
  }

  perch_blog_categories();
  perch_blog_tags();
  perch_blog_date_archive_years();

  perch_layout('global/footer');
