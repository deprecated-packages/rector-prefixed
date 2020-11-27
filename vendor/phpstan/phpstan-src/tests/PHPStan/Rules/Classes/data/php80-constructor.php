<?php

namespace _PhpScopera143bcca66cb;

class OldStyleConstructorOnPhp8
{
    public function OldStyleConstructorOnPhp8(int $i)
    {
    }
    public static function create() : self
    {
        return new self(1);
    }
}
\class_alias('_PhpScopera143bcca66cb\\OldStyleConstructorOnPhp8', 'OldStyleConstructorOnPhp8', \false);
function () {
    new \_PhpScopera143bcca66cb\OldStyleConstructorOnPhp8();
    new \_PhpScopera143bcca66cb\OldStyleConstructorOnPhp8(1);
};
