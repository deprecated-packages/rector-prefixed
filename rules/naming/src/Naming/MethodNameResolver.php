<?php

declare (strict_types=1);
namespace Rector\Naming\Naming;

use _PhpScoperbf340cb0be9d\Nette\Utils\Strings;
use PhpParser\Node\Expr;
use Rector\NetteKdyby\Naming\VariableNaming;
final class MethodNameResolver
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    public function __construct(\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->variableNaming = $variableNaming;
    }
    public function resolveGetterFromReturnedExpr(\PhpParser\Node\Expr $expr) : ?string
    {
        $variableName = $this->variableNaming->resolveFromNode($expr);
        if ($variableName === null) {
            return null;
        }
        return 'get' . \ucfirst($variableName);
    }
    public function resolveIsserFromReturnedExpr(\PhpParser\Node\Expr $expr) : ?string
    {
        $variableName = $this->variableNaming->resolveFromNode($expr);
        if ($variableName === null) {
            return null;
        }
        if (\_PhpScoperbf340cb0be9d\Nette\Utils\Strings::match($variableName, '#^(is)#')) {
            return $variableName;
        }
        return 'is' . \ucfirst($variableName);
    }
}
