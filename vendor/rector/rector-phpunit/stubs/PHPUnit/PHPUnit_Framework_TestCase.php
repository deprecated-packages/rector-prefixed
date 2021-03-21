<?php

declare (strict_types=1);
namespace RectorPrefix20210321;

if (\class_exists('RectorPrefix20210321\\PHPUnit_Framework_TestCase')) {
    return;
}
abstract class PHPUnit_Framework_TestCase
{
}
\class_alias('RectorPrefix20210321\\PHPUnit_Framework_TestCase', 'PHPUnit_Framework_TestCase', \false);
