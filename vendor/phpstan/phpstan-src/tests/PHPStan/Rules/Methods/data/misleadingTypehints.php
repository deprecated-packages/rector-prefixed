<?php

namespace _PhpScoper006a73f0e455;

class FooWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScoper006a73f0e455\boolean
    {
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return new \_PhpScoper006a73f0e455\boolean();
        }
    }
    public function misleadingIntReturnType() : \_PhpScoper006a73f0e455\integer
    {
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return new \_PhpScoper006a73f0e455\integer();
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
            return new \_PhpScoper006a73f0e455\mixed();
        }
    }
}
\class_alias('_PhpScoper006a73f0e455\\FooWithoutNamespace', 'FooWithoutNamespace', \false);
