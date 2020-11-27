<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\DuplicateMethod;

class Lesson
{
    use LessonTrait;
    public function test() : void
    {
        $this->doFoo();
    }
}
