<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node as PhpDocParserNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoper0a6b37af0871\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
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
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
    }
    /**
     * @param Type[] $oldTypes
     */
    public function renamePhpDocTypes(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, array $oldTypes, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $newType, \_PhpScoper0a6b37af0871\PhpParser\Node $phpParserNode) : void
    {
        foreach ($oldTypes as $oldType) {
            $this->renamePhpDocType($phpDocNode, $oldType, $newType, $phpParserNode);
        }
    }
    public function renamePhpDocType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $oldType, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $newType, \_PhpScoper0a6b37af0871\PhpParser\Node $phpParserNode) : bool
    {
        $this->phpDocNodeTraverser->traverseWithCallable($phpDocNode, '', function (\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node $node) use($phpParserNode, $oldType, $newType) : PhpDocParserNode {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
                return $node;
            }
            $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($node, $phpParserNode);
            // make sure to compare FQNs
            if ($staticType instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType) {
                $staticType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($staticType->getFullyQualifiedName());
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
