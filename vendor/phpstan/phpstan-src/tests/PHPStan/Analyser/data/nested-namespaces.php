<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\x;

class boo
{
}
namespace _PhpScoperabd03f0baf05\y;

use _PhpScoperabd03f0baf05\x\boo;
use _PhpScoperabd03f0baf05\x\baz;
class x
{
    /** @var \x\boo */
    private $boo;
    /** @var \x\baz */
    private $baz;
    public function __construct(\_PhpScoperabd03f0baf05\x\boo $boo, \_PhpScoperabd03f0baf05\x\baz $baz)
    {
        $this->boo = $boo;
        $this->baz = $baz;
    }
}
