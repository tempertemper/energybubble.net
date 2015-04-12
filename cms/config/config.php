<?php

  $http_host = getenv('HTTP_HOST');
  switch($http_host)
  {

  case('energybubble.local') :
    define('PERCH_SITEPATH', '***REMOVED***');
    define("PERCH_DB_USERNAME", '***REMOVED***');
    define("PERCH_DB_PASSWORD", '***REMOVED***');
    define("PERCH_DB_DATABASE", "energybubble-local");
    define('PERCH_PRODUCTION_MODE', PERCH_DEVELOPMENT);
    break;

  case('***REMOVED***') :
    define("PERCH_DB_USERNAME", '***REMOVED***');
    define("PERCH_DB_PASSWORD", '***REMOVED***');
    define("PERCH_DB_SERVER", "localhost");
    define('PERCH_PRODUCTION_MODE', PERCH_STAGING);
    break;

  default :
    define("PERCH_DB_USERNAME", 'energybubble');
    define("PERCH_DB_PASSWORD", '***REMOVED***');
    define("PERCH_DB_DATABASE", "energybubble-production");
    define('PERCH_PRODUCTION_MODE', PERCH_PRODUCTION);
    break;
  }

  define('PERCH_LICENSE_KEY', '***REMOVED***');
  define("PERCH_DB_SERVER", "localhost");
  define("PERCH_DB_PREFIX", "perch2_");
  define('PERCH_TZ', 'UTC');

  define('PERCH_EMAIL_METHOD', 'smtp');
  define('PERCH_EMAIL_FROM', '***REMOVED***');
  define('PERCH_EMAIL_FROM_NAME', 'energybubble');
  define('PERCH_EMAIL_AUTH', true);
  define('PERCH_EMAIL_SECURE', 'tls');
  define("PERCH_EMAIL_HOST", "smtp.postmarkapp.com");
  define('PERCH_EMAIL_USERNAME', '***REMOVED***');
  define('PERCH_EMAIL_PASSWORD', '***REMOVED***');

  define('PERCH_LOGINPATH', '/cms');
  define('PERCH_PATH', str_replace(DIRECTORY_SEPARATOR.'config', '', __DIR__));
  define('PERCH_CORE', PERCH_PATH.DIRECTORY_SEPARATOR.'core');

  define('PERCH_RESFILEPATH', PERCH_PATH . DIRECTORY_SEPARATOR . 'resources');
  define('PERCH_RESPATH', PERCH_LOGINPATH . '/resources');

  define('PERCH_HTML5', true);
  define('PERCH_RWD', true);



