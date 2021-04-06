<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;
use Rector\Core\Configuration\CurrentNodeProvider;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use RectorPrefix20210406\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor;
final class ClassRenamePhpDocNodeVisitor extends \RectorPrefix20210406\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var CurrentNodeProvider
     */
    private $currentNodeProvider;
    /**
     * @var array<string, string>
     */
    private $oldToNewClasses = [];
    public function __construct(\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->currentNodeProvider = $currentNodeProvider;
    }
    public function beforeTraverse(\PHPStan\PhpDocParser\Ast\Node $node) : void
    {
        if ($this->oldToNewClasses === []) {
            throw new \Rector\Core\Exception\ShouldNotHappenException('Configure "$oldToNewClasses" first');
        }
    }
    public function enterNode(\PHPStan\PhpDocParser\Ast\Node $node) : ?\PHPStan\PhpDocParser\Ast\Node
    {
        if (!$node instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return null;
        }
        $phpParserNode = $this->currentNodeProvider->getNode();
        if (!$phpParserNode instanceof \PhpParser\Node) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($node, $phpParserNode);
        // make sure to compare FQNs
        if ($staticType instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            $staticType = new \PHPStan\Type\ObjectType($staticType->getFullyQualifiedName());
        }
        foreach ($this->oldToNewClasses as $oldClass => $newClass) {
            $oldType = new \PHPStan\Type\ObjectType($oldClass);
            $newType = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($newClass);
            if (!$staticType->equals($oldType)) {
                continue;
            }
            $newTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($newType);
            $parentType = $node->getAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::PARENT);
            if ($parentType instanceof \PHPStan\PhpDocParser\Ast\Type\TypeNode) {
                // mirror attributes
                $newTypeNode->setAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::PARENT, $parentType);
            }
            return $newTypeNode;
        }
        return null;
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    public function setOldToNewClasses(array $oldToNewClasses) : void
    {
        $this->oldToNewClasses = $oldToNewClasses;
    }
}
