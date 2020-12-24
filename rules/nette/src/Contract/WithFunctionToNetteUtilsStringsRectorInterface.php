<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Contract;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
interface WithFunctionToNetteUtilsStringsRectorInterface
{
    public function getMethodName() : string;
    public function matchContentAndNeedleOfSubstrOfVariableLength(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScopere8e811afab72\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
}
