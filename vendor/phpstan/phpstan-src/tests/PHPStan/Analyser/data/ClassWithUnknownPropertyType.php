<?php

namespace _PhpScoper88fe6e0ad041;

class ClassWithUnknownPropertyType
{
    /** @var ClassWithUnknownParent|self */
    protected $test;
}
\class_alias('_PhpScoper88fe6e0ad041\\ClassWithUnknownPropertyType', 'ClassWithUnknownPropertyType', \false);
