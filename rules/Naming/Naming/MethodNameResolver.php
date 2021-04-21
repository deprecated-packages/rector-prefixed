<?php

declare (strict_types=1);
namespace Rector\Naming\Naming;

use RectorPrefix20210421\Nette\Utils\Strings;
use PhpParser\Node\Expr;
final class MethodNameResolver
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    public function __construct(\Rector\Naming\Naming\VariableNaming $variableNaming)
    {
        $this->variableNaming = $variableNaming;
    }
    /**
     * @return string|null
     */
    public function resolveGetterFromReturnedExpr(\PhpParser\Node\Expr $expr)
    {
        $variableName = $this->variableNaming->resolveFromNode($expr);
        if ($variableName === null) {
            return null;
        }
        return 'get' . \ucfirst($variableName);
    }
    /**
     * @return string|null
     */
    public function resolveIsserFromReturnedExpr(\PhpParser\Node\Expr $expr)
    {
        $variableName = $this->variableNaming->resolveFromNode($expr);
        if ($variableName === null) {
            return null;
        }
        if (\RectorPrefix20210421\Nette\Utils\Strings::match($variableName, '#^(is)#')) {
            return $variableName;
        }
        return 'is' . \ucfirst($variableName);
    }
}
