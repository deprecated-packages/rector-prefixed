<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Naming;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming;
final class MethodNameResolver
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->variableNaming = $variableNaming;
    }
    public function resolveGetterFromReturnedExpr(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : ?string
    {
        $variableName = $this->variableNaming->resolveFromNode($expr);
        if ($variableName === null) {
            return null;
        }
        return 'get' . \ucfirst($variableName);
    }
    public function resolveIsserFromReturnedExpr(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : ?string
    {
        $variableName = $this->variableNaming->resolveFromNode($expr);
        if ($variableName === null) {
            return null;
        }
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::match($variableName, '#^(is)#')) {
            return $variableName;
        }
        return 'is' . \ucfirst($variableName);
    }
}
