<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node as PhpDocParserNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
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
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
    }
    /**
     * @param Type[] $oldTypes
     */
    public function renamePhpDocTypes(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, array $oldTypes, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $newType, \_PhpScoperb75b35f52b74\PhpParser\Node $phpParserNode) : void
    {
        foreach ($oldTypes as $oldType) {
            $this->renamePhpDocType($phpDocNode, $oldType, $newType, $phpParserNode);
        }
    }
    public function renamePhpDocType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $oldType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $newType, \_PhpScoperb75b35f52b74\PhpParser\Node $phpParserNode) : bool
    {
        $this->phpDocNodeTraverser->traverseWithCallable($phpDocNode, '', function (\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node) use($phpParserNode, $oldType, $newType) : PhpDocParserNode {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
                return $node;
            }
            $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($node, $phpParserNode);
            // make sure to compare FQNs
            if ($staticType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
                $staticType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($staticType->getFullyQualifiedName());
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
