<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\x;

class boo
{
}
namespace _PhpScopera143bcca66cb\y;

use _PhpScopera143bcca66cb\x\boo;
use _PhpScopera143bcca66cb\x\baz;
class x
{
    /** @var \x\boo */
    private $boo;
    /** @var \x\baz */
    private $baz;
    public function __construct(\_PhpScopera143bcca66cb\x\boo $boo, \_PhpScopera143bcca66cb\x\baz $baz)
    {
        $this->boo = $boo;
        $this->baz = $baz;
    }
}
