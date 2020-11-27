<?php

namespace _PhpScoper88fe6e0ad041\SwitchGetClass;

class Foo
{
    public function doFoo()
    {
        $lorem = doFoo();
        switch (\get_class($lorem)) {
            case \_PhpScoper88fe6e0ad041\SwitchGetClass\Ipsum::class:
                break;
            case \_PhpScoper88fe6e0ad041\SwitchGetClass\Lorem::class:
                'normalName';
                break;
            case self::class:
                'selfReferentialName';
                break;
        }
    }
}
