<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php72\Contract;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
interface ConvertToAnonymousFunctionRectorInterface
{
    public function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool;
    /**
     * @return Param[]
     */
    public function getParameters(\_PhpScopere8e811afab72\PhpParser\Node $node) : array;
    /**
     * @return Identifier|Name|NullableType|UnionType|null
     */
    public function getReturnType(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node;
    /**
     * @return Expression[]|Stmt[]
     */
    public function getBody(\_PhpScopere8e811afab72\PhpParser\Node $node) : array;
}
