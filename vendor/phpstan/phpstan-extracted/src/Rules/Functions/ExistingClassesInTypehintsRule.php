<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Functions;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InFunctionNode;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use RectorPrefix20201227\PHPStan\Rules\FunctionDefinitionCheck;
/**
 * @implements \PHPStan\Rules\Rule<InFunctionNode>
 */
class ExistingClassesInTypehintsRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionDefinitionCheck */
    private $check;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\FunctionDefinitionCheck $check)
    {
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\InFunctionNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->getFunction() instanceof \RectorPrefix20201227\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection) {
            return [];
        }
        $functionName = $scope->getFunction()->getName();
        return $this->check->checkFunction($node->getOriginalNode(), $scope->getFunction(), \sprintf('Parameter $%%s of function %s() has invalid typehint type %%s.', $functionName), \sprintf('Return typehint of function %s() has invalid type %%s.', $functionName), \sprintf('Function %s() uses native union types but they\'re supported only on PHP 8.0 and later.', $functionName));
    }
}
