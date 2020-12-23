<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
final class AssignDimFetchFormTypeResolver implements \_PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        // traverse up and find all $this['some_name'] = $type
        /** @var Assign|null $formVariableAssign */
        $formVariableAssign = $this->betterNodeFinder->findPreviousAssignToExpr($node);
        if ($formVariableAssign === null) {
            return [];
        }
        if (!$node->dim instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return [];
        }
        $exprType = $this->nodeTypeResolver->getStaticType($formVariableAssign->expr);
        if (!$exprType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return [];
        }
        $name = $node->dim->value;
        return [$name => $exprType->getClassName()];
    }
}
