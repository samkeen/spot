<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-06-06 09:39:09 --- ERROR: ErrorException [ 2048 ]: Non-static method Form::check_group() should not be called statically ~ APPPATH/views/admin/pages/markers_edit.php [ 18 ]
2010-06-06 09:39:31 --- ERROR: ErrorException [ 1 ]: Using $this when not in object context ~ APPPATH/classes/form.php [ 62 ]
2010-06-06 09:55:09 --- ERROR: Kohana_Exception [ 0 ]: The spaces property does not exist in the Model_Marker class ~ MODPATH/orm/classes/kohana/orm.php [ 425 ]
2010-06-06 10:00:17 --- ERROR: Kohana_Exception [ 0 ]: The spaces property does not exist in the Model_Marker class ~ MODPATH/orm/classes/kohana/orm.php [ 425 ]
2010-06-06 10:00:32 --- ERROR: Kohana_Exception [ 0 ]: The space property does not exist in the Model_Marker class ~ MODPATH/orm/classes/kohana/orm.php [ 425 ]
2010-06-06 10:11:50 --- ERROR: Database_Exception [ 1146 ]: Table 'seating.placement' doesn't exist [ SELECT * FROM `spaces` JOIN `placement` ON (`placement`.`space_id` = `spaces`.`id`) WHERE `placement`.`marker_id` = '22' ORDER BY `spaces`.`id` ASC ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 174 ]
2010-06-06 10:13:27 --- ERROR: Kohana_Exception [ 0 ]: The spaces property does not exist in the Model_Marker class ~ MODPATH/orm/classes/kohana/orm.php [ 425 ]
2010-06-06 10:15:02 --- ERROR: Kohana_Exception [ 0 ]: The spaces property does not exist in the Model_Marker class ~ MODPATH/orm/classes/kohana/orm.php [ 425 ]
2010-06-06 10:18:27 --- ERROR: Kohana_Exception [ 0 ]: The spaces property does not exist in the Model_Marker class ~ MODPATH/orm/classes/kohana/orm.php [ 426 ]
2010-06-06 10:20:59 --- ERROR: Kohana_Exception [ 0 ]: The spaces property does not exist in the Model_Marker class ~ MODPATH/orm/classes/kohana/orm.php [ 426 ]
2010-06-06 10:22:56 --- ERROR: Kohana_Exception [ 0 ]: The spaces property does not exist in the Model_Marker class ~ MODPATH/orm/classes/kohana/orm.php [ 427 ]
2010-06-06 10:23:13 --- ERROR: Kohana_Exception [ 0 ]: The spaces property does not exist in the Model_Marker class ~ MODPATH/orm/classes/kohana/orm.php [ 427 ]
2010-06-06 10:26:15 --- ERROR: ErrorException [ 8 ]: Undefined index: placements ~ MODPATH/orm/classes/kohana/orm.php [ 1056 ]
2010-06-06 10:27:04 --- ERROR: ErrorException [ 8 ]: Undefined index: placement ~ MODPATH/orm/classes/kohana/orm.php [ 1056 ]
2010-06-06 10:27:35 --- ERROR: ErrorException [ 8 ]: Undefined index: placement ~ MODPATH/orm/classes/kohana/orm.php [ 1057 ]
2010-06-06 10:28:18 --- ERROR: ErrorException [ 2 ]: Missing argument 2 for Kohana_ORM::has(), called in /private/var/www/placementsk3/application/classes/controller/admin/markers.php on line 43 and defined ~ MODPATH/orm/classes/kohana/orm.php [ 1052 ]
2010-06-06 10:47:32 --- ERROR: ErrorException [ 1 ]: Call to private Kohana_Profiler::__construct() from context 'Controller_Admin_Markers' ~ APPPATH/classes/controller/admin/markers.php [ 9 ]
2010-06-06 10:53:09 --- ERROR: ErrorException [ 1 ]: Call to private Kohana_Profiler::__construct() from context 'Controller_Admin_Markers' ~ APPPATH/classes/controller/admin/markers.php [ 9 ]
2010-06-06 11:22:12 --- ERROR: ErrorException [ 8 ]: Undefined index: space ~ MODPATH/orm/classes/kohana/orm.php [ 1054 ]
2010-06-06 11:28:55 --- ERROR: Kohana_Exception [ 0 ]: The space_id property does not exist in the Model_Space class ~ MODPATH/orm/classes/kohana/orm.php [ 373 ]
2010-06-06 20:39:47 --- ERROR: ErrorException [ 8 ]: Undefined variable: site ~ APPPATH/classes/controller/api/sites.php [ 10 ]
2010-06-06 20:47:55 --- ERROR: ErrorException [ 1 ]: Call to a member function as_array() on a non-object ~ APPPATH/classes/controller/api/sites.php [ 10 ]
2010-06-06 20:48:31 --- ERROR: ErrorException [ 1 ]: Call to a member function as_array() on a non-object ~ APPPATH/classes/controller/api/sites.php [ 10 ]
2010-06-06 21:00:20 --- ERROR: ErrorException [ 1 ]: Call to undefined method Database_MySQL_Result::execute() ~ APPPATH/classes/controller/api/sites.php [ 9 ]
2010-06-06 21:17:00 --- ERROR: ReflectionException [ 0 ]: Method action_1 does not exist ~ SYSPATH/classes/kohana/request.php [ 996 ]
2010-06-06 21:24:07 --- ERROR: ErrorException [ 1 ]: Call to a member function as_array() on a non-object ~ APPPATH/classes/controller/api/sites.php [ 18 ]
2010-06-06 21:24:38 --- ERROR: ErrorException [ 1 ]: Call to a member function as_array() on a non-object ~ APPPATH/classes/controller/api/sites.php [ 18 ]
2010-06-06 21:29:40 --- ERROR: ReflectionException [ -1 ]: Class controller_api_home does not exist ~ SYSPATH/classes/kohana/request.php [ 978 ]
2010-06-06 21:32:35 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: api/sites/index/a ~ SYSPATH/classes/kohana/request.php [ 635 ]
2010-06-06 21:35:07 --- ERROR: ReflectionException [ 0 ]: Method action_1 does not exist ~ SYSPATH/classes/kohana/request.php [ 996 ]