<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InArrowFunctionNode;
use PHPStan\Rules\FunctionReturnTypeCheck;
use PHPStan\Type\ObjectType;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\InArrowFunctionNode>
 */
class ArrowFunctionReturnTypeRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionReturnTypeCheck */
    private $returnTypeCheck;
    public function __construct(\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck)
    {
        $this->returnTypeCheck = $returnTypeCheck;
    }
    public function getNodeType() : string
    {
        return \PHPStan\Node\InArrowFunctionNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInAnonymousFunction()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        /** @var \PHPStan\Type\Type $returnType */
        $returnType = $scope->getAnonymousFunctionReturnType();
        $generatorType = new \PHPStan\Type\ObjectType(\Generator::class);
        return $this->returnTypeCheck->checkReturnType($scope, $returnType, $node->getOriginalNode()->expr, 'Anonymous function should return %s but empty return statement found.', 'Anonymous function with return type void returns %s but should not return anything.', 'Anonymous function should return %s but returns %s.', 'Anonymous function should never return but return statement found.', $generatorType->isSuperTypeOf($returnType)->yes());
    }
}
