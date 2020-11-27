<?php

namespace _PhpScoper26e51eeacccf\DefinedVariables;

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
