<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\x;

class boo
{
}
namespace _PhpScoper006a73f0e455\y;

use _PhpScoper006a73f0e455\x\boo;
use _PhpScoper006a73f0e455\x\baz;
class x
{
    /** @var \x\boo */
    private $boo;
    /** @var \x\baz */
    private $baz;
    public function __construct(\_PhpScoper006a73f0e455\x\boo $boo, \_PhpScoper006a73f0e455\x\baz $baz)
    {
        $this->boo = $boo;
        $this->baz = $baz;
    }
}
