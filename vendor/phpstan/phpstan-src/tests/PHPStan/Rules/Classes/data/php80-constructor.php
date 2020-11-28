<?php

namespace _PhpScoperabd03f0baf05;

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
\class_alias('_PhpScoperabd03f0baf05\\OldStyleConstructorOnPhp8', 'OldStyleConstructorOnPhp8', \false);
function () {
    new \_PhpScoperabd03f0baf05\OldStyleConstructorOnPhp8();
    new \_PhpScoperabd03f0baf05\OldStyleConstructorOnPhp8(1);
};
