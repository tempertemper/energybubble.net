<?php

  define('PERCH_LICENSE_KEY', 'P21207-AHK231-GUF081-CTE575-FPM024');

  $http_host = getenv('HTTP_HOST');
  switch($http_host)
  {

  case('energybubble.local') :
    define("PERCH_DB_USERNAME", 'admin');
    define("PERCH_DB_PASSWORD", 'Carmen28');
    define("PERCH_DB_SERVER", "localhost");
    define("PERCH_DB_DATABASE", "energybubble");
    define('PERCH_PRODUCTION_MODE', PERCH_DEVELOPMENT);
   break;

  default :
    define("PERCH_DB_USERNAME", 'energybubble');
    define("PERCH_DB_PASSWORD", '***REMOVED***');
    define("PERCH_DB_DATABASE", "energybubble");
    define('PERCH_PRODUCTION_MODE', PERCH_PRODUCTION);
    break;
  }

  define("PERCH_DB_SERVER", "localhost");
  define("PERCH_DB_PREFIX", "perch2_");

  define('PERCH_EMAIL_METHOD', 'smtp');
  define('PERCH_EMAIL_FROM', '***REMOVED***');
  define('PERCH_EMAIL_FROM_NAME', 'energybubble');
  define('PERCH_EMAIL_AUTH', true);
  define('PERCH_EMAIL_SECURE', 'tls');
  define("PERCH_EMAIL_HOST", "smtp.postmarkapp.com");
  define('PERCH_EMAIL_USERNAME', '***REMOVED***');
  define('PERCH_EMAIL_PASSWORD', '***REMOVED***');

  define('PERCH_LOGINPATH', '/cms');
  define('PERCH_PATH', str_replace(DIRECTORY_SEPARATOR.'config', '', dirname(__FILE__)));
  define('PERCH_CORE', PERCH_PATH.DIRECTORY_SEPARATOR.'core');

  define('PERCH_RESFILEPATH', PERCH_PATH . DIRECTORY_SEPARATOR . 'resources');
  define('PERCH_RESPATH', PERCH_LOGINPATH . '/resources');

  define('PERCH_HTML5', true);
  define('PERCH_RWD', true);

?>