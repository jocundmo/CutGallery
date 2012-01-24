<?php defined('SYSPATH') or die('No direct script access.'); ?>

2012-01-09 14:23:15 +01:00 --- error: Kohana_Exception [ 403 ]: @todo FORBIDDEN
C:\xampp\htdocs\gallery3\modules\gallery\helpers\access.php [ 202 ]
#0 C:\xampp\htdocs\gallery3\modules\gallery\helpers\access.php(425): access_Core::forbidden()
#1 C:\xampp\htdocs\gallery3\modules\gallery\controllers\login.php(52): access_Core::verify_csrf()
#2 [internal function]: Login_Controller->auth_html()
#3 C:\xampp\htdocs\gallery3\system\core\Kohana.php(331): ReflectionMethod->invokeArgs(Object(Login_Controller), Array)
#4 [internal function]: Kohana_Core::instance(NULL)
#5 C:\xampp\htdocs\gallery3\system\core\Event.php(208): call_user_func_array(Array, Array)
#6 C:\xampp\htdocs\gallery3\application\Bootstrap.php(67): Event_Core::run('system.execute')
#7 C:\xampp\htdocs\gallery3\index.php(102): require('C:\xampp\htdocs...')
#8 {main}
2012-01-09 14:23:15 +01:00 --- error: Missing messages entry kohana/core.errors.403 for message kohana/core
