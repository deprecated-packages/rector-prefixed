<?php

namespace _PhpScoperabd03f0baf05;

class FooWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScoperabd03f0baf05\boolean
    {
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return new \_PhpScoperabd03f0baf05\boolean();
        }
    }
    public function misleadingIntReturnType() : \_PhpScoperabd03f0baf05\integer
    {
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return new \_PhpScoperabd03f0baf05\integer();
        }
    }
    public function misleadingMixedReturnType() : mixed
    {
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return new \_PhpScoperabd03f0baf05\mixed();
        }
    }
}
\class_alias('_PhpScoperabd03f0baf05\\FooWithoutNamespace', 'FooWithoutNamespace', \false);
