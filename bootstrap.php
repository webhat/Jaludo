<?php
if (!function_exists('loader')) {
    function loader($class)
    {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $file = "./" . $class . '.php';

        if (file_exists("./" . $file)) {
            require "./" . $file;
        } else if (file_exists("./build/classes/" . $file)) {
            require "./build/classes/" . $file;
        } else if (file_exists("./tests/" . $file)) {
            require "./tests/" . $file;
        }
    }
}

spl_autoload_register('loader');

// FIXME: hack to use composer rather than pear
if (!file_exists('vendor/propel/propel1/runtime/lib/Propel.php'))
    chdir("..");

// Include the main Propel script
require_once getcwd() . '/vendor/propel/propel1/runtime/lib/Propel.php';

// Initialize Propel with the runtime configuration
Propel::init(getcwd() . "/build/conf/jaludo-conf.php");

// Add the generated 'classes' directory to the include path
//set_include_path("/path/to/bookstore/build/classes" . PATH_SEPARATOR . get_include_path());