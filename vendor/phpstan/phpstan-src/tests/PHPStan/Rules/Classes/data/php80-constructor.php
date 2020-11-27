<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\OldStyleConstructorOnPhp8', 'OldStyleConstructorOnPhp8', \false);
function () {
    new \_PhpScoperbd5d0c5f7638\OldStyleConstructorOnPhp8();
    new \_PhpScoperbd5d0c5f7638\OldStyleConstructorOnPhp8(1);
};
