<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Node as PhpDocParserNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use RectorPrefix20210302\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
final class DocBlockClassRenamer
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var PhpDocNodeTraverser
     */
    private $phpDocNodeTraverser;
    public function __construct(\RectorPrefix20210302\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
    }
    /**
     * @param Type[] $oldTypes
     */
    public function renamePhpDocTypes(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, array $oldTypes, \PHPStan\Type\Type $newType, \PhpParser\Node $phpParserNode) : void
    {
        foreach ($oldTypes as $oldType) {
            $this->renamePhpDocType($phpDocInfo, $oldType, $newType, $phpParserNode);
        }
    }
    public function renamePhpDocType(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \PHPStan\Type\Type $oldType, \PHPStan\Type\Type $newType, \PhpParser\Node $phpParserNode) : void
    {
        $this->phpDocNodeTraverser->traverseWithCallable($phpDocInfo->getPhpDocNode(), '', function (\PHPStan\PhpDocParser\Ast\Node $node) use($phpDocInfo, $phpParserNode, $oldType, $newType) : PhpDocParserNode {
            if (!$node instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
                return $node;
            }
            $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($node, $phpParserNode);
            // make sure to compare FQNs
            if ($staticType instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
                $staticType = new \PHPStan\Type\ObjectType($staticType->getFullyQualifiedName());
            }
            if (!$staticType->equals($oldType)) {
                return $node;
            }
            $phpDocInfo->markAsChanged();
            return $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($newType);
        });
    }
}
