<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Functions;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\FunctionReturnTypeCheck;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Return_>
 */
class ClosureReturnTypeRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionReturnTypeCheck */
    private $returnTypeCheck;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck)
    {
        $this->returnTypeCheck = $returnTypeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInAnonymousFunction()) {
            return [];
        }
        /** @var \PHPStan\Type\Type $returnType */
        $returnType = $scope->getAnonymousFunctionReturnType();
        $generatorType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\Generator::class);
        return $this->returnTypeCheck->checkReturnType($scope, $returnType, $node->expr, 'Anonymous function should return %s but empty return statement found.', 'Anonymous function with return type void returns %s but should not return anything.', 'Anonymous function should return %s but returns %s.', 'Anonymous function should never return but return statement found.', $generatorType->isSuperTypeOf($returnType)->yes());
    }
}
