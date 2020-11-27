<?php

namespace _PhpScoper26e51eeacccf;

class ClassWithUnknownPropertyType
{
    /** @var ClassWithUnknownParent|self */
    protected $test;
}
\class_alias('_PhpScoper26e51eeacccf\\ClassWithUnknownPropertyType', 'ClassWithUnknownPropertyType', \false);
