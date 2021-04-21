<?php

declare(strict_types=1);

namespace Rector\Naming\Naming;

use Nette\Utils\Strings;
use PhpParser\Node\Expr;

final class MethodNameResolver
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;

    public function __construct(VariableNaming $variableNaming)
    {
        $this->variableNaming = $variableNaming;
    }

    /**
     * @return string|null
     */
    public function resolveGetterFromReturnedExpr(Expr $expr)
    {
        $variableName = $this->variableNaming->resolveFromNode($expr);
        if ($variableName === null) {
            return null;
        }

        return 'get' . ucfirst($variableName);
    }

    /**
     * @return string|null
     */
    public function resolveIsserFromReturnedExpr(Expr $expr)
    {
        $variableName = $this->variableNaming->resolveFromNode($expr);
        if ($variableName === null) {
            return null;
        }

        if (Strings::match($variableName, '#^(is)#')) {
            return $variableName;
        }

        return 'is' . ucfirst($variableName);
    }
}
