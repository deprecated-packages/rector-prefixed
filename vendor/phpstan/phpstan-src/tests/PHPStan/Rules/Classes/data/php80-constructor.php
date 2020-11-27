<?php

namespace _PhpScoper006a73f0e455;

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
\class_alias('_PhpScoper006a73f0e455\\OldStyleConstructorOnPhp8', 'OldStyleConstructorOnPhp8', \false);
function () {
    new \_PhpScoper006a73f0e455\OldStyleConstructorOnPhp8();
    new \_PhpScoper006a73f0e455\OldStyleConstructorOnPhp8(1);
};
