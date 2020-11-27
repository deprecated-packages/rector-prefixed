<?php

namespace _PhpScopera143bcca66cb\DefinedVariables;

class Bar
{
    public static function doBar(&$passedByReference)
    {
        $passedByReference = 1;
    }
    public static function doBaz()
    {
        self::doBar($newVariable);
        echo $newVariable;
    }
}
