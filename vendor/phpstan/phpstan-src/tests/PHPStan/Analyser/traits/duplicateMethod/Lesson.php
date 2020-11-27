<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\DuplicateMethod;

class Lesson
{
    use LessonTrait;
    public function test() : void
    {
        $this->doFoo();
    }
}
