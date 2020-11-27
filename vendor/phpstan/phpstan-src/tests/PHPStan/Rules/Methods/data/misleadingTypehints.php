<?php

namespace _PhpScoper88fe6e0ad041;

class FooWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScoper88fe6e0ad041\boolean
    {
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return new \_PhpScoper88fe6e0ad041\boolean();
        }
    }
    public function misleadingIntReturnType() : \_PhpScoper88fe6e0ad041\integer
    {
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return new \_PhpScoper88fe6e0ad041\integer();
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
            return new \_PhpScoper88fe6e0ad041\mixed();
        }
    }
}
\class_alias('_PhpScoper88fe6e0ad041\\FooWithoutNamespace', 'FooWithoutNamespace', \false);
