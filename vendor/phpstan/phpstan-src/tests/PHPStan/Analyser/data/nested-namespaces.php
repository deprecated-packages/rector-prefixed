<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\x;

class boo
{
}
namespace _PhpScoperbd5d0c5f7638\y;

use _PhpScoperbd5d0c5f7638\x\boo;
use _PhpScoperbd5d0c5f7638\x\baz;
class x
{
    /** @var \x\boo */
    private $boo;
    /** @var \x\baz */
    private $baz;
    public function __construct(\_PhpScoperbd5d0c5f7638\x\boo $boo, \_PhpScoperbd5d0c5f7638\x\baz $baz)
    {
        $this->boo = $boo;
        $this->baz = $baz;
    }
}
