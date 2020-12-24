<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PostRector\Contract\Rector;

use _PhpScopere8e811afab72\PhpParser\NodeVisitor;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\RectorInterface;
interface PostRectorInterface extends \_PhpScopere8e811afab72\PhpParser\NodeVisitor, \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\RectorInterface
{
    /**
     * Higher values are executed first
     */
    public function getPriority() : int;
}
