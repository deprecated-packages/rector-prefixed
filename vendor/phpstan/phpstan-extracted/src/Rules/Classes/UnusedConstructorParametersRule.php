<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Classes;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InClassMethodNode;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Rules\UnusedFunctionParametersCheck;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class UnusedConstructorParametersRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\UnusedFunctionParametersCheck */
    private $check;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\UnusedFunctionParametersCheck $check)
    {
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $method = $scope->getFunction();
        if (!$method instanceof \RectorPrefix20201227\PHPStan\Reflection\MethodReflection) {
            return [];
        }
        $originalNode = $node->getOriginalNode();
        if (\strtolower($method->getName()) !== '__construct' || $originalNode->stmts === null) {
            return [];
        }
        if (\count($originalNode->params) === 0) {
            return [];
        }
        $message = \sprintf('Constructor of class %s has an unused parameter $%%s.', $scope->getClassReflection()->getDisplayName());
        if ($scope->getClassReflection()->isAnonymous()) {
            $message = 'Constructor of an anonymous class has an unused parameter $%s.';
        }
        return $this->check->getUnusedParameters($scope, \array_map(static function (\PhpParser\Node\Param $parameter) : string {
            if (!$parameter->var instanceof \PhpParser\Node\Expr\Variable || !\is_string($parameter->var->name)) {
                throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
            }
            return $parameter->var->name;
        }, \array_values(\array_filter($originalNode->params, static function (\PhpParser\Node\Param $parameter) : bool {
            return $parameter->flags === 0;
        }))), $originalNode->stmts, $message, 'constructor.unusedParameter', []);
    }
}
