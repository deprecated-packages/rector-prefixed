<?php

namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\OldStyleConstructorOnPhp8', 'OldStyleConstructorOnPhp8', \false);
function () {
    new \_PhpScoper88fe6e0ad041\OldStyleConstructorOnPhp8();
    new \_PhpScoper88fe6e0ad041\OldStyleConstructorOnPhp8(1);
};
