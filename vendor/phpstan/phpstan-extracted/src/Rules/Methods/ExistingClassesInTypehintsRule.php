<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Methods;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InClassMethodNode;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use RectorPrefix20201227\PHPStan\Rules\FunctionDefinitionCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\InClassMethodNode>
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
        return \RectorPrefix20201227\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $methodReflection = $scope->getFunction();
        if (!$methodReflection instanceof \RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        if (!$scope->isInClass()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return $this->check->checkClassMethod($methodReflection, $node->getOriginalNode(), \sprintf('Parameter $%%s of method %s::%s() has invalid typehint type %%s.', $scope->getClassReflection()->getDisplayName(), $methodReflection->getName()), \sprintf('Return typehint of method %s::%s() has invalid type %%s.', $scope->getClassReflection()->getDisplayName(), $methodReflection->getName()), \sprintf('Method %s::%s() uses native union types but they\'re supported only on PHP 8.0 and later.', $scope->getClassReflection()->getDisplayName(), $methodReflection->getName()));
    }
}
