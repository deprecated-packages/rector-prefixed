<?php

namespace _PhpScoper006a73f0e455\DefinedVariables;

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
