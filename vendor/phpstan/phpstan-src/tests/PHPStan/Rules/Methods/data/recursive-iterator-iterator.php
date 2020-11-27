<?php

namespace _PhpScoperbd5d0c5f7638\RecursiveIteratorIteratorMixin;

class Foo
{
    public function doFoo() : void
    {
        $it = new \RecursiveDirectoryIterator(__DIR__);
        $it = new \RecursiveIteratorIterator($it);
        foreach ($it as $_) {
            echo $it->getSubPathname();
            echo $it->getSubPathname(1);
        }
    }
}
