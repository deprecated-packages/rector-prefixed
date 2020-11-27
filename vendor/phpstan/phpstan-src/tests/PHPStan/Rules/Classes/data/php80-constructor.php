<?php

namespace _PhpScoper26e51eeacccf;

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
\class_alias('_PhpScoper26e51eeacccf\\OldStyleConstructorOnPhp8', 'OldStyleConstructorOnPhp8', \false);
function () {
    new \_PhpScoper26e51eeacccf\OldStyleConstructorOnPhp8();
    new \_PhpScoper26e51eeacccf\OldStyleConstructorOnPhp8(1);
};
