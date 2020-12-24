<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PostRector\Rector;

use _PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector\NameResolverTrait;
use _PhpScoperb75b35f52b74\Rector\PostRector\Contract\Rector\PostRectorInterface;
abstract class AbstractPostRector extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract implements \_PhpScoperb75b35f52b74\Rector\PostRector\Contract\Rector\PostRectorInterface
{
    use NameResolverTrait;
}
