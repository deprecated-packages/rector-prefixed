<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode;
use Rector\BetterPhpDocParser\Attributes\AttributeMirrorer;
use Rector\BetterPhpDocParser\Contract\BasePhpDocNodeVisitorInterface;
use Rector\BetterPhpDocParser\DataProvider\CurrentTokenIteratorProvider;
use Rector\BetterPhpDocParser\ValueObject\PhpDoc\SpacingAwareTemplateTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;
use Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
use Rector\Core\Exception\ShouldNotHappenException;
use RectorPrefix20210406\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor;
final class TemplatePhpDocNodeVisitor extends \RectorPrefix20210406\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor implements \Rector\BetterPhpDocParser\Contract\BasePhpDocNodeVisitorInterface
{
    /**
     * @var CurrentTokenIteratorProvider
     */
    private $currentTokenIteratorProvider;
    /**
     * @var AttributeMirrorer
     */
    private $attributeMirrorer;
    public function __construct(\Rector\BetterPhpDocParser\DataProvider\CurrentTokenIteratorProvider $currentTokenIteratorProvider, \Rector\BetterPhpDocParser\Attributes\AttributeMirrorer $attributeMirrorer)
    {
        $this->currentTokenIteratorProvider = $currentTokenIteratorProvider;
        $this->attributeMirrorer = $attributeMirrorer;
    }
    public function enterNode(\PHPStan\PhpDocParser\Ast\Node $node) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        if (!$node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode) {
            return null;
        }
        if ($node instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDoc\SpacingAwareTemplateTagValueNode) {
            return null;
        }
        $betterTokenIterator = $this->currentTokenIteratorProvider->provide();
        $startAndEnd = $node->getAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::START_AND_END);
        if (!$startAndEnd instanceof \Rector\BetterPhpDocParser\ValueObject\StartAndEnd) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $docContent = $betterTokenIterator->printFromTo($startAndEnd->getStart(), $startAndEnd->getEnd());
        $spacingAwareTemplateTagValueNode = new \Rector\BetterPhpDocParser\ValueObject\PhpDoc\SpacingAwareTemplateTagValueNode($node->name, $node->bound, $node->description, $docContent);
        $this->attributeMirrorer->mirror($node, $spacingAwareTemplateTagValueNode);
        return $spacingAwareTemplateTagValueNode;
    }
}
