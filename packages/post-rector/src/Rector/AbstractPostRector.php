<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PostRector\Rector;

use _PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector\NameResolverTrait;
use _PhpScopere8e811afab72\Rector\PostRector\Contract\Rector\PostRectorInterface;
abstract class AbstractPostRector extends \_PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract implements \_PhpScopere8e811afab72\Rector\PostRector\Contract\Rector\PostRectorInterface
{
    use NameResolverTrait;
}
