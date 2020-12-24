<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Nette\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
interface WithFunctionToNetteUtilsStringsRectorInterface
{
    public function getMethodName() : string;
    public function matchContentAndNeedleOfSubstrOfVariableLength(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper2a4e7ab1ecbc\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
}
