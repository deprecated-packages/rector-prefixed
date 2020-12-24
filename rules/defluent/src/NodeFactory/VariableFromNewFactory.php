<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming;
final class VariableFromNewFactory
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->variableNaming = $variableNaming;
    }
    public function create(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable
    {
        $variableName = $this->variableNaming->resolveFromNode($new);
        if ($variableName === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($variableName);
    }
}
