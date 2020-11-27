<?php

namespace _PhpScoper006a73f0e455\Bug3782;

class HelloWorld
{
    /** @param mixed[] $data */
    public function sayHello(array $data) : void
    {
        foreach ($data as $key => $value) {
            $this[$key] = $value;
        }
    }
}
