<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Functions;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\FunctionDefinitionCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ArrowFunction>
 */
class ExistingClassesInArrowFunctionTypehintsRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionDefinitionCheck */
    private $check;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\FunctionDefinitionCheck $check)
    {
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrowFunction::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        return $this->check->checkAnonymousFunction($scope, $node->getParams(), $node->getReturnType(), 'Parameter $%s of anonymous function has invalid typehint type %s.', 'Return typehint of anonymous function has invalid type %s.', 'Anonymous function uses native union types but they\'re supported only on PHP 8.0 and later.');
    }
}
