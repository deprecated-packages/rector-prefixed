<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\DuplicateMethod;

class Lesson
{
    use LessonTrait;
    public function test() : void
    {
        $this->doFoo();
    }
}
