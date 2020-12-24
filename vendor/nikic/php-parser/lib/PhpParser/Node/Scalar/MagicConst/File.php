<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\MagicConst;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\MagicConst;
class File extends \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__FILE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_File';
    }
}
