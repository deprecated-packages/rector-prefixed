<?php

namespace _PhpScoper88fe6e0ad041\Bug3782;

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
