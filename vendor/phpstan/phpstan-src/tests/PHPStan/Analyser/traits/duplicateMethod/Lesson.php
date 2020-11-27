<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\DuplicateMethod;

class Lesson
{
    use LessonTrait;
    public function test() : void
    {
        $this->doFoo();
    }
}
