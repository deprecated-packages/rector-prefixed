<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Nette\Contract;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
interface WithFunctionToNetteUtilsStringsRectorInterface
{
    public function getMethodName() : string;
    public function matchContentAndNeedleOfSubstrOfVariableLength(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper0a2ac50786fa\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
}
