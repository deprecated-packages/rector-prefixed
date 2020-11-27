<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\x;

class boo
{
}
namespace _PhpScoper26e51eeacccf\y;

use _PhpScoper26e51eeacccf\x\boo;
use _PhpScoper26e51eeacccf\x\baz;
class x
{
    /** @var \x\boo */
    private $boo;
    /** @var \x\baz */
    private $baz;
    public function __construct(\_PhpScoper26e51eeacccf\x\boo $boo, \_PhpScoper26e51eeacccf\x\baz $baz)
    {
        $this->boo = $boo;
        $this->baz = $baz;
    }
}
