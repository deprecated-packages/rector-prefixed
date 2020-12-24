<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Rector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitorAbstract;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector\NameResolverTrait;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Contract\Rector\PostRectorInterface;
abstract class AbstractPostRector extends \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitorAbstract implements \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Contract\Rector\PostRectorInterface
{
    use NameResolverTrait;
}
