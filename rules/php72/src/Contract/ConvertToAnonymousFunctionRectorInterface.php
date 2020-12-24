<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php72\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\UnionType;
interface ConvertToAnonymousFunctionRectorInterface
{
    public function shouldSkip(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool;
    /**
     * @return Param[]
     */
    public function getParameters(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : array;
    /**
     * @return Identifier|Name|NullableType|UnionType|null
     */
    public function getReturnType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node;
    /**
     * @return Expression[]|Stmt[]
     */
    public function getBody(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : array;
}
