<?php
class autoloader
{
    public static function daoautoloader($class)
    {
        $path = DOCUMENT_ROOT . "/dataobjects/{$class}.php";
        if (is_readable($path)) require $path;
    }

    public static function utilautoloader($class)
    {
        $path = DOCUMENT_ROOT . "/util/{$class}.php";
        if (is_readable($path)) require $path;
    }

    public static function coreautoloader($class)
    {
        $path = DOCUMENT_ROOT . "/core/{$class}.php";
        if (is_readable($path)) require $path;
    }

    public static function helpersautoloader($class)
    {
        $path = DOCUMENT_ROOT . "/helpers/{$class}.php";
        if (is_readable($path)) require $path;
    }

    public static function librariesautoloader($class)
    {
        $path = DOCUMENT_ROOT . "/libraries/{$class}.php";
        if (is_readable($path)) require $path;
    }

    public static function langautoloader($class)
    {
        $path = DOCUMENT_ROOT . "/lang/{$class}.php";
        if (is_readable($path)) require $path;
    }

    public static function databaseautoloader($class)
    {
        $path = DOCUMENT_ROOT . "/database/{$class}.php";
        if (is_readable($path)) require $path;
    }
}
spl_autoload_register('autoloader::coreautoloader');
spl_autoload_register('autoloader::utilautoloader');
spl_autoload_register('autoloader::daoautoloader');
spl_autoload_register('autoloader::helpersautoloader');
spl_autoload_register('autoloader::librariesautoloader');
spl_autoload_register('autoloader::langautoloader');
spl_autoload_register('autoloader::databaseautoloader');

?>
