<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Functions;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InArrowFunctionNode;
use RectorPrefix20201227\PHPStan\Rules\FunctionReturnTypeCheck;
use PHPStan\Type\ObjectType;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\InArrowFunctionNode>
 */
class ArrowFunctionReturnTypeRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionReturnTypeCheck */
    private $returnTypeCheck;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck)
    {
        $this->returnTypeCheck = $returnTypeCheck;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\InArrowFunctionNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInAnonymousFunction()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        /** @var \PHPStan\Type\Type $returnType */
        $returnType = $scope->getAnonymousFunctionReturnType();
        $generatorType = new \PHPStan\Type\ObjectType(\Generator::class);
        return $this->returnTypeCheck->checkReturnType($scope, $returnType, $node->getOriginalNode()->expr, 'Anonymous function should return %s but empty return statement found.', 'Anonymous function with return type void returns %s but should not return anything.', 'Anonymous function should return %s but returns %s.', 'Anonymous function should never return but return statement found.', $generatorType->isSuperTypeOf($returnType)->yes());
    }
}
