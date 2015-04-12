<?php

  perch_layout('global/header', [
    'body-class' => 'home',
  ]);

  perch_content('Main heading');

  perch_pages_navigation([
    'levels'=>1
  ]);

  perch_content('Primary content');

  perch_layout('global/footer');
