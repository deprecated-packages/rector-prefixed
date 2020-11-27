<?php

namespace _PhpScopera143bcca66cb\SwitchGetClass;

class Foo
{
    public function doFoo()
    {
        $lorem = doFoo();
        switch (\get_class($lorem)) {
            case \_PhpScopera143bcca66cb\SwitchGetClass\Ipsum::class:
                break;
            case \_PhpScopera143bcca66cb\SwitchGetClass\Lorem::class:
                'normalName';
                break;
            case self::class:
                'selfReferentialName';
                break;
        }
    }
}
