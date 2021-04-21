<?php

declare (strict_types=1);
namespace Rector\CodeQuality\TypeResolver;

use PhpParser\Node\Expr\Assign;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class AssignVariableTypeResolver
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function resolve(\PhpParser\Node\Expr\Assign $assign) : \PHPStan\Type\Type
    {
        $variableType = $this->nodeTypeResolver->resolve($assign->var);
        $exprType = $this->nodeTypeResolver->resolve($assign->expr);
        if ($exprType instanceof \PHPStan\Type\UnionType) {
            $variableType = $exprType;
        }
        return $variableType;
    }
}
