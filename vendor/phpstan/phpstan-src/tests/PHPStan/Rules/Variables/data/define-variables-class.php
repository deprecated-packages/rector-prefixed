<?php

namespace _PhpScoperbd5d0c5f7638\DefinedVariables;

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
