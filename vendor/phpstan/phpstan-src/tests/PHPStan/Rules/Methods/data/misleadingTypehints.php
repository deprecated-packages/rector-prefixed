<?php

namespace _PhpScopera143bcca66cb;

class FooWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScopera143bcca66cb\boolean
    {
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return new \_PhpScopera143bcca66cb\boolean();
        }
    }
    public function misleadingIntReturnType() : \_PhpScopera143bcca66cb\integer
    {
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return new \_PhpScopera143bcca66cb\integer();
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
            return new \_PhpScopera143bcca66cb\mixed();
        }
    }
}
\class_alias('_PhpScopera143bcca66cb\\FooWithoutNamespace', 'FooWithoutNamespace', \false);
