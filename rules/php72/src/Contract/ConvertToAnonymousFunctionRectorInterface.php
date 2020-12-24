<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php72\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\UnionType;
interface ConvertToAnonymousFunctionRectorInterface
{
    public function shouldSkip(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool;
    /**
     * @return Param[]
     */
    public function getParameters(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array;
    /**
     * @return Identifier|Name|NullableType|UnionType|null
     */
    public function getReturnType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node;
    /**
     * @return Expression[]|Stmt[]
     */
    public function getBody(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array;
}
