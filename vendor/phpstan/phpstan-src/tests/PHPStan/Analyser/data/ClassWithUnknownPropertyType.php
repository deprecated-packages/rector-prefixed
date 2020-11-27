<?php

namespace _PhpScoper006a73f0e455;

class ClassWithUnknownPropertyType
{
    /** @var ClassWithUnknownParent|self */
    protected $test;
}
\class_alias('_PhpScoper006a73f0e455\\ClassWithUnknownPropertyType', 'ClassWithUnknownPropertyType', \false);
