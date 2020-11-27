<?php

namespace _PhpScopera143bcca66cb;

class ClassWithUnknownPropertyType
{
    /** @var ClassWithUnknownParent|self */
    protected $test;
}
\class_alias('_PhpScopera143bcca66cb\\ClassWithUnknownPropertyType', 'ClassWithUnknownPropertyType', \false);
