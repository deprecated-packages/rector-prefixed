<?php

namespace _PhpScoperbd5d0c5f7638\SwitchGetClass;

class Foo
{
    public function doFoo()
    {
        $lorem = doFoo();
        switch (\get_class($lorem)) {
            case \_PhpScoperbd5d0c5f7638\SwitchGetClass\Ipsum::class:
                break;
            case \_PhpScoperbd5d0c5f7638\SwitchGetClass\Lorem::class:
                'normalName';
                break;
            case self::class:
                'selfReferentialName';
                break;
        }
    }
}
