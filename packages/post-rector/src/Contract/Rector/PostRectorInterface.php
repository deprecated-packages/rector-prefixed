<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Contract\Rector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitor;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\RectorInterface;
interface PostRectorInterface extends \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitor, \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\RectorInterface
{
    /**
     * Higher values are executed first
     */
    public function getPriority() : int;
}
