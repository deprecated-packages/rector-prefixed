<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PostRector\Rector;

use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector\NameResolverTrait;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Contract\Rector\PostRectorInterface;
abstract class AbstractPostRector extends \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract implements \_PhpScoper0a2ac50786fa\Rector\PostRector\Contract\Rector\PostRectorInterface
{
    use NameResolverTrait;
}
