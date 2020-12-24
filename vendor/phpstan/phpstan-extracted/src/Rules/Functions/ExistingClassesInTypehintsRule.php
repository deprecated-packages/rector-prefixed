<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Functions;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\InFunctionNode;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use _PhpScoperb75b35f52b74\PHPStan\Rules\FunctionDefinitionCheck;
/**
 * @implements \PHPStan\Rules\Rule<InFunctionNode>
 */
class ExistingClassesInTypehintsRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionDefinitionCheck */
    private $check;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\FunctionDefinitionCheck $check)
    {
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Node\InFunctionNode::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->getFunction() instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection) {
            return [];
        }
        $functionName = $scope->getFunction()->getName();
        return $this->check->checkFunction($node->getOriginalNode(), $scope->getFunction(), \sprintf('Parameter $%%s of function %s() has invalid typehint type %%s.', $functionName), \sprintf('Return typehint of function %s() has invalid type %%s.', $functionName), \sprintf('Function %s() uses native union types but they\'re supported only on PHP 8.0 and later.', $functionName));
    }
}
