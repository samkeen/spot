<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Los_Angeles');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * Base URL for the application. (Default "/") Can be a complete or partial URL. For
 * example "http://example.com/kohana/" or just "/kohana/" would both work.
 *
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * The PHP file that starts the application. (Default "index.php") Set to FALSE when you remove 
 * the index file from the URL with URL rewriting.
 *
 * - string   charset     internal character set used for input and output   utf-8
 * Character set used for all input and output. (Default "utf-8") Should be a character set that is supported
 * by both htmlspecialchars and iconv.
 *
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * Cache file directory. (Default "application/cache") Must point to a writable directory.
 *
 * - boolean  errors      enable or disable error handling                   TRUE
 * Use internal error and exception handling? (Default TRUE) Set to FALSE to disable the Kohana error and exception handlers.
 *
 * - boolean  profile     enable or disable internal profiling               TRUE
 * Do internal profiling? (Default TRUE) Set to FALSE  to disable internal profiling. Disable in production for best performance.
 *
 * - boolean  caching     enable or disable internal caching                 FALSE
 * Cache the location of files between requests? (Default FALSE) Set to TRUE to cache the absolute path of files.
 * This dramatically speeds up Kohana::find_file  and can sometimes have a dramatic impact on performance.
 * Only enable in a production environment, or for testing.
 */
Kohana::init(array(
	'base_url'   => '/',
	'index_file' => FALSE,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	// 'auth'       => MODPATH.'auth',       // Basic authentication
	// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   => MODPATH.'database',   // Database access
	// 'image'      => MODPATH.'image',      // Image manipulation
	 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'pagination' => MODPATH.'pagination', // Paging of results
	 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
// allow /api/sites/1  (rather than /api/sites/index/1
Route::set('api_index', 'api(/<controller>(/<id>))',array('id'=>'\d+'))
    ->defaults(array(
        'directory'  => 'api',
        'controller' => 'home',
        'action'     => 'index',
    )
);
Route::set('api', 'api(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory'  => 'api',
        'controller' => 'home',
        'action'     => 'index',
    )
);
Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory'  => 'admin',
        'controller' => 'home',
        'action'     => 'index',
    )
);
Route::set('default', '(<controller>(/<action>(/<id>)))',
    // allow email as id (ie: /spaces/with/sam@somewhere.com)
    array('id' => '[a-zA-Z0-9_\.@]++'))
    ->defaults(array(
        'controller' => 'welcome',
        'action'     => 'index',
    )
);

/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
echo Request::instance()
	->execute()
	->send_headers()
	->response;
