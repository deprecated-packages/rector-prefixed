<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PostRector\Rector;

use _PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector\NameResolverTrait;
use _PhpScoper0a6b37af0871\Rector\PostRector\Contract\Rector\PostRectorInterface;
abstract class AbstractPostRector extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract implements \_PhpScoper0a6b37af0871\Rector\PostRector\Contract\Rector\PostRectorInterface
{
    use NameResolverTrait;
}
