<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
interface WithFunctionToNetteUtilsStringsRectorInterface
{
    public function getMethodName() : string;
    public function matchContentAndNeedleOfSubstrOfVariableLength(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoperb75b35f52b74\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
}
