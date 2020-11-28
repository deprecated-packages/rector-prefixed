<?php

namespace _PhpScoperabd03f0baf05\SwitchGetClass;

class Foo
{
    public function doFoo()
    {
        $lorem = doFoo();
        switch (\get_class($lorem)) {
            case \_PhpScoperabd03f0baf05\SwitchGetClass\Ipsum::class:
                break;
            case \_PhpScoperabd03f0baf05\SwitchGetClass\Lorem::class:
                'normalName';
                break;
            case self::class:
                'selfReferentialName';
                break;
        }
    }
}
