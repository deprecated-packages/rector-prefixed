<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\DuplicateMethod;

class Lesson
{
    use LessonTrait;
    public function test() : void
    {
        $this->doFoo();
    }
}
