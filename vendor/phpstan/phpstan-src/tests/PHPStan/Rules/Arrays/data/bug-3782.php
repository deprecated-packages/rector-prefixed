<?php

namespace _PhpScoperbd5d0c5f7638\Bug3782;

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
