<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\MagicConst;

use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\MagicConst;
class Line extends \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__LINE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Line';
    }
}
