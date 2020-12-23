<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

// faking cake php App class
// see https://github.com/cakephp/cakephp/blob/2.4.1/lib/Cake/Core/App.php#L521
final class App
{
    public static function uses($className, $location)
    {
        // self::$_classMap[$className] = $location;
    }
}
// faking cake php App class
// see https://github.com/cakephp/cakephp/blob/2.4.1/lib/Cake/Core/App.php#L521
\class_alias('_PhpScoper0a2ac50786fa\\App', 'App', \false);
