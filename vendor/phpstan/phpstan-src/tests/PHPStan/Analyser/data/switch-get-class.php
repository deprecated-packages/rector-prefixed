<?php

namespace _PhpScoper006a73f0e455\SwitchGetClass;

class Foo
{
    public function doFoo()
    {
        $lorem = doFoo();
        switch (\get_class($lorem)) {
            case \_PhpScoper006a73f0e455\SwitchGetClass\Ipsum::class:
                break;
            case \_PhpScoper006a73f0e455\SwitchGetClass\Lorem::class:
                'normalName';
                break;
            case self::class:
                'selfReferentialName';
                break;
        }
    }
}
