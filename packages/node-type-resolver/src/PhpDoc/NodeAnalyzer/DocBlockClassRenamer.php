<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node as PhpDocParserNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScopere8e811afab72\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
final class DocBlockClassRenamer
{
    /**
     * @var bool
     */
    private $hasNodeChanged = \false;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var PhpDocNodeTraverser
     */
    private $phpDocNodeTraverser;
    public function __construct(\_PhpScopere8e811afab72\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
    }
    /**
     * @param Type[] $oldTypes
     */
    public function renamePhpDocTypes(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, array $oldTypes, \_PhpScopere8e811afab72\PHPStan\Type\Type $newType, \_PhpScopere8e811afab72\PhpParser\Node $phpParserNode) : void
    {
        foreach ($oldTypes as $oldType) {
            $this->renamePhpDocType($phpDocNode, $oldType, $newType, $phpParserNode);
        }
    }
    public function renamePhpDocType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScopere8e811afab72\PHPStan\Type\Type $oldType, \_PhpScopere8e811afab72\PHPStan\Type\Type $newType, \_PhpScopere8e811afab72\PhpParser\Node $phpParserNode) : bool
    {
        $this->phpDocNodeTraverser->traverseWithCallable($phpDocNode, '', function (\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node) use($phpParserNode, $oldType, $newType) : PhpDocParserNode {
            if (!$node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
                return $node;
            }
            $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($node, $phpParserNode);
            // make sure to compare FQNs
            if ($staticType instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType) {
                $staticType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($staticType->getFullyQualifiedName());
            }
            if (!$staticType->equals($oldType)) {
                return $node;
            }
            $this->hasNodeChanged = \true;
            return $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($newType);
        });
        return $this->hasNodeChanged;
    }
}
