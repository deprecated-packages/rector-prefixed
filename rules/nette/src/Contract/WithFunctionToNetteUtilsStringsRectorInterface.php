<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
interface WithFunctionToNetteUtilsStringsRectorInterface
{
    public function getMethodName() : string;
    public function matchContentAndNeedleOfSubstrOfVariableLength(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper0a6b37af0871\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
}
