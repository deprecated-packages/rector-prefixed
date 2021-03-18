<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\FormControlTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Scalar\String_;
use PHPStan\Type\TypeWithClassName;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class AssignDimFetchFormTypeResolver implements \Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\PhpParser\Node $node) : array
    {
        if (!$node instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        // traverse up and find all $this['some_name'] = $type
        /** @var Assign|null $formVariableAssign */
        $formVariableAssign = $this->betterNodeFinder->findPreviousAssignToExpr($node);
        if (!$formVariableAssign instanceof \PhpParser\Node\Expr\Assign) {
            return [];
        }
        if (!$node->dim instanceof \PhpParser\Node\Scalar\String_) {
            return [];
        }
        $exprType = $this->nodeTypeResolver->getStaticType($formVariableAssign->expr);
        if (!$exprType instanceof \PHPStan\Type\TypeWithClassName) {
            return [];
        }
        $name = $node->dim->value;
        return [$name => $exprType->getClassName()];
    }
}
