<?php defined('SYSPATH') or die('No direct script access.'); ?>

2012-01-08 17:46:39 +01:00 --- error: File not found: user_profile/show/3
2012-01-08 17:48:18 +01:00 --- error: Kohana_Exception [ 403 ]: @todo FORBIDDEN
C:\xampp\htdocs\gallery3\modules\gallery\helpers\access.php [ 202 ]
#0 C:\xampp\htdocs\gallery3\modules\gallery\helpers\access.php(129): access_Core::forbidden()
#1 C:\xampp\htdocs\gallery3\modules\gallery\controllers\quick.php(79): access_Core::required('edit', Object(Item_Model))
#2 [internal function]: Quick_Controller->form_delete('2')
#3 C:\xampp\htdocs\gallery3\system\core\Kohana.php(331): ReflectionMethod->invokeArgs(Object(Quick_Controller), Array)
#4 [internal function]: Kohana_Core::instance(NULL)
#5 C:\xampp\htdocs\gallery3\system\core\Event.php(208): call_user_func_array(Array, Array)
#6 C:\xampp\htdocs\gallery3\application\Bootstrap.php(67): Event_Core::run('system.execute')
#7 C:\xampp\htdocs\gallery3\index.php(102): require('C:\xampp\htdocs...')
#8 {main}
2012-01-08 17:48:18 +01:00 --- error: Missing messages entry kohana/core.errors.403 for message kohana/core
2012-01-08 17:48:21 +01:00 --- error: Kohana_Exception [ 403 ]: @todo FORBIDDEN
C:\xampp\htdocs\gallery3\modules\gallery\helpers\access.php [ 202 ]
#0 C:\xampp\htdocs\gallery3\modules\gallery\helpers\access.php(129): access_Core::forbidden()
#1 C:\xampp\htdocs\gallery3\modules\gallery\controllers\quick.php(79): access_Core::required('edit', Object(Item_Model))
#2 [internal function]: Quick_Controller->form_delete('2')
#3 C:\xampp\htdocs\gallery3\system\core\Kohana.php(331): ReflectionMethod->invokeArgs(Object(Quick_Controller), Array)
#4 [internal function]: Kohana_Core::instance(NULL)
#5 C:\xampp\htdocs\gallery3\system\core\Event.php(208): call_user_func_array(Array, Array)
#6 C:\xampp\htdocs\gallery3\application\Bootstrap.php(67): Event_Core::run('system.execute')
#7 C:\xampp\htdocs\gallery3\index.php(102): require('C:\xampp\htdocs...')
#8 {main}
2012-01-08 17:48:21 +01:00 --- error: Missing messages entry kohana/core.errors.403 for message kohana/core
2012-01-08 17:53:36 +01:00 --- error: @todo MISSING_MODEL user:1
#0 C:\xampp\htdocs\gallery3\modules\user\helpers\user.php(35): model_cache_Core::get('user', 1)
#1 C:\xampp\htdocs\gallery3\modules\user\libraries\drivers\IdentityProvider\Gallery.php(28): user_Core::guest()
#2 C:\xampp\htdocs\gallery3\modules\gallery\libraries\IdentityProvider.php(173): IdentityProvider_Gallery_Driver->guest()
#3 C:\xampp\htdocs\gallery3\modules\gallery\helpers\identity.php(147): IdentityProvider_Core->guest()
#4 C:\xampp\htdocs\gallery3\modules\gallery\helpers\gallery_event.php(219): identity_Core::guest()
#5 C:\xampp\htdocs\gallery3\modules\gallery\helpers\module.php(381): gallery_event_Core::user_menu(Object(Menu), Object(Theme_View))
#6 C:\xampp\htdocs\gallery3\modules\gallery\libraries\Theme_View.php(88): module_Core::event('user_menu', Object(Menu), Object(Theme_View))
#7 C:\xampp\htdocs\gallery3\themes\wind\views\page.html.php(98): Theme_View_Core->user_menu()
#8 C:\xampp\htdocs\gallery3\system\libraries\View.php(318): include('C:\xampp\htdocs...')
#9 C:\xampp\htdocs\gallery3\system\libraries\View.php(260): View_Core->load_view('C:/xampp/htdocs...', Array)
#10 C:\xampp\htdocs\gallery3\modules\gallery\libraries\MY_View.php(75): View_Core->render(false, false, false)
#11 C:\xampp\htdocs\gallery3\system\libraries\View.php(226): View->render()
#12 C:\xampp\htdocs\gallery3\modules\gallery\controllers\albums.php(77): View_Core->__toString()
#13 C:\xampp\htdocs\gallery3\modules\gallery\controllers\albums.php(22): Albums_Controller->show(Object(Item_Model))
#14 [internal function]: Albums_Controller->index()
#15 C:\xampp\htdocs\gallery3\system\core\Kohana.php(331): ReflectionMethod->invokeArgs(Object(Albums_Controller), Array)
#16 [internal function]: Kohana_Core::instance(NULL)
#17 C:\xampp\htdocs\gallery3\system\core\Event.php(208): call_user_func_array(Array, Array)
#18 C:\xampp\htdocs\gallery3\application\Bootstrap.php(67): Event_Core::run('system.execute')
#19 C:\xampp\htdocs\gallery3\index.php(102): require('C:\xampp\htdocs...')
#20 {main}
2012-01-08 17:53:42 +01:00 --- error: @todo MISSING_MODEL user:1
#0 C:\xampp\htdocs\gallery3\modules\user\helpers\user.php(35): model_cache_Core::get('user', 1)
#1 C:\xampp\htdocs\gallery3\modules\user\libraries\drivers\IdentityProvider\Gallery.php(28): user_Core::guest()
#2 C:\xampp\htdocs\gallery3\modules\gallery\libraries\IdentityProvider.php(173): IdentityProvider_Gallery_Driver->guest()
#3 C:\xampp\htdocs\gallery3\modules\gallery\helpers\identity.php(147): IdentityProvider_Core->guest()
#4 C:\xampp\htdocs\gallery3\modules\gallery\helpers\gallery_event.php(219): identity_Core::guest()
#5 C:\xampp\htdocs\gallery3\modules\gallery\helpers\module.php(381): gallery_event_Core::user_menu(Object(Menu), Object(Theme_View))
#6 C:\xampp\htdocs\gallery3\modules\gallery\libraries\Theme_View.php(88): module_Core::event('user_menu', Object(Menu), Object(Theme_View))
#7 C:\xampp\htdocs\gallery3\themes\wind\views\page.html.php(98): Theme_View_Core->user_menu()
#8 C:\xampp\htdocs\gallery3\system\libraries\View.php(318): include('C:\xampp\htdocs...')
#9 C:\xampp\htdocs\gallery3\system\libraries\View.php(260): View_Core->load_view('C:/xampp/htdocs...', Array)
#10 C:\xampp\htdocs\gallery3\modules\gallery\libraries\MY_View.php(75): View_Core->render(false, false, false)
#11 C:\xampp\htdocs\gallery3\system\libraries\View.php(226): View->render()
#12 C:\xampp\htdocs\gallery3\modules\gallery\controllers\albums.php(77): View_Core->__toString()
#13 C:\xampp\htdocs\gallery3\modules\gallery\controllers\albums.php(22): Albums_Controller->show(Object(Item_Model))
#14 [internal function]: Albums_Controller->index()
#15 C:\xampp\htdocs\gallery3\system\core\Kohana.php(331): ReflectionMethod->invokeArgs(Object(Albums_Controller), Array)
#16 [internal function]: Kohana_Core::instance(NULL)
#17 C:\xampp\htdocs\gallery3\system\core\Event.php(208): call_user_func_array(Array, Array)
#18 C:\xampp\htdocs\gallery3\application\Bootstrap.php(67): Event_Core::run('system.execute')
#19 C:\xampp\htdocs\gallery3\index.php(102): require('C:\xampp\htdocs...')
#20 {main}
