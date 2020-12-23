<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PostRector\Contract\Rector;

use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitor;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\RectorInterface;
interface PostRectorInterface extends \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitor, \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\RectorInterface
{
    /**
     * Higher values are executed first
     */
    public function getPriority() : int;
}
