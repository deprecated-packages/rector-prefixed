<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\DuplicateMethod;

class Lesson
{
    use LessonTrait;
    public function test() : void
    {
        $this->doFoo();
    }
}
