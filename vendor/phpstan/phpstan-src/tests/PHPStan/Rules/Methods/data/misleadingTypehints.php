<?php

namespace _PhpScoper26e51eeacccf;

class FooWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScoper26e51eeacccf\boolean
    {
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return new \_PhpScoper26e51eeacccf\boolean();
        }
    }
    public function misleadingIntReturnType() : \_PhpScoper26e51eeacccf\integer
    {
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return new \_PhpScoper26e51eeacccf\integer();
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
            return new \_PhpScoper26e51eeacccf\mixed();
        }
    }
}
\class_alias('_PhpScoper26e51eeacccf\\FooWithoutNamespace', 'FooWithoutNamespace', \false);
