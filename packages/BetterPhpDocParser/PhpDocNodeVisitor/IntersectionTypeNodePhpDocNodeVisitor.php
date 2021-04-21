<?php

declare(strict_types=1);

namespace Rector\BetterPhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use Rector\BetterPhpDocParser\Attributes\AttributeMirrorer;
use Rector\BetterPhpDocParser\Contract\BasePhpDocNodeVisitorInterface;
use Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareIntersectionTypeNode;
use Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor;

final class IntersectionTypeNodePhpDocNodeVisitor extends AbstractPhpDocNodeVisitor implements BasePhpDocNodeVisitorInterface
{
    /**
     * @var AttributeMirrorer
     */
    private $attributeMirrorer;

    public function __construct(AttributeMirrorer $attributeMirrorer)
    {
        $this->attributeMirrorer = $attributeMirrorer;
    }

    /**
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(Node $node)
    {
        if (! $node instanceof IntersectionTypeNode) {
            return null;
        }

        if ($node instanceof BracketsAwareIntersectionTypeNode) {
            return null;
        }

        $bracketsAwareIntersectionTypeNode = new BracketsAwareIntersectionTypeNode($node->types);
        $this->attributeMirrorer->mirror($node, $bracketsAwareIntersectionTypeNode);

        return $bracketsAwareIntersectionTypeNode;
    }
}
