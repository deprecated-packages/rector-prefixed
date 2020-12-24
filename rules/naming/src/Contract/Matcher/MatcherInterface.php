<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Contract\Matcher;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObject\VariableAndCallAssign;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObject\VariableAndCallForeach;
interface MatcherInterface
{
    public function getVariable(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
    public function getVariableName(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string;
    /**
     * @return VariableAndCallAssign|VariableAndCallForeach
     */
    public function match(\_PhpScoperb75b35f52b74\PhpParser\Node $node);
}
