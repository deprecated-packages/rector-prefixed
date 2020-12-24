<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PostRector\Contract\Rector;

use _PhpScoperb75b35f52b74\PhpParser\NodeVisitor;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface;
interface PostRectorInterface extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitor, \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface
{
    /**
     * Higher values are executed first
     */
    public function getPriority() : int;
}
