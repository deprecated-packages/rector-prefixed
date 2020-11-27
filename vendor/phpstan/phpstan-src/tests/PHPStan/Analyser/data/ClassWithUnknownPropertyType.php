<?php

namespace _PhpScoperbd5d0c5f7638;

class ClassWithUnknownPropertyType
{
    /** @var ClassWithUnknownParent|self */
    protected $test;
}
\class_alias('_PhpScoperbd5d0c5f7638\\ClassWithUnknownPropertyType', 'ClassWithUnknownPropertyType', \false);
