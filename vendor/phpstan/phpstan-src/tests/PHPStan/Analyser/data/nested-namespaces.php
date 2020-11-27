<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\x;

class boo
{
}
namespace _PhpScoper88fe6e0ad041\y;

use _PhpScoper88fe6e0ad041\x\boo;
use _PhpScoper88fe6e0ad041\x\baz;
class x
{
    /** @var \x\boo */
    private $boo;
    /** @var \x\baz */
    private $baz;
    public function __construct(\_PhpScoper88fe6e0ad041\x\boo $boo, \_PhpScoper88fe6e0ad041\x\baz $baz)
    {
        $this->boo = $boo;
        $this->baz = $baz;
    }
}
