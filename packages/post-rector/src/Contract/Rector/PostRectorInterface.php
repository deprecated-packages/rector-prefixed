<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PostRector\Contract\Rector;

use _PhpScoper0a6b37af0871\PhpParser\NodeVisitor;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface;
interface PostRectorInterface extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitor, \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface
{
    /**
     * Higher values are executed first
     */
    public function getPriority() : int;
}
