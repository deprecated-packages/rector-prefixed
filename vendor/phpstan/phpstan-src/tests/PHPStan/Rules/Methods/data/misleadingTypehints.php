<?php

namespace _PhpScoperbd5d0c5f7638;

class FooWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScoperbd5d0c5f7638\boolean
    {
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return new \_PhpScoperbd5d0c5f7638\boolean();
        }
    }
    public function misleadingIntReturnType() : \_PhpScoperbd5d0c5f7638\integer
    {
        if (\rand(0, 1)) {
            return 1;
        }
        if (\rand(0, 1)) {
            return \true;
        }
        if (\rand(0, 1)) {
            return new \_PhpScoperbd5d0c5f7638\integer();
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
            return new \_PhpScoperbd5d0c5f7638\mixed();
        }
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\FooWithoutNamespace', 'FooWithoutNamespace', \false);
