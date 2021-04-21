<?php

declare(strict_types=1);

namespace Rector\NodeNameResolver\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassConst;
use Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use Rector\NodeNameResolver\NodeNameResolver;

final class ClassConstNameResolver implements NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @required
     * @return void
     */
    public function autowireClassConstNameResolver(NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }

    /**
     * @return class-string<Node>
     */
    public function getNode(): string
    {
        return ClassConst::class;
    }

    /**
     * @param ClassConst $node
     * @return string|null
     */
    public function resolve(Node $node)
    {
        if ($node->consts === []) {
            return null;
        }

        $onlyConstant = $node->consts[0];

        return $this->nodeNameResolver->getName($onlyConstant);
    }
}
