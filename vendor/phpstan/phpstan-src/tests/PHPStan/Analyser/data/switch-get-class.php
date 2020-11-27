<?php

namespace _PhpScoper26e51eeacccf\SwitchGetClass;

class Foo
{
    public function doFoo()
    {
        $lorem = doFoo();
        switch (\get_class($lorem)) {
            case \_PhpScoper26e51eeacccf\SwitchGetClass\Ipsum::class:
                break;
            case \_PhpScoper26e51eeacccf\SwitchGetClass\Lorem::class:
                'normalName';
                break;
            case self::class:
                'selfReferentialName';
                break;
        }
    }
}
