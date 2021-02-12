<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PhpDoc;

use RectorPrefix20210212\Nette\Utils\Strings;
use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Node as PhpDocParserNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Renaming\ValueObject\PseudoNamespaceToNamespace;
use Rector\StaticTypeMapper\StaticTypeMapper;
use RectorPrefix20210212\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
final class PhpDocTypeRenamer
{
    /**
     * @var PhpDocNodeTraverser
     */
    private $phpDocNodeTraverser;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    public function __construct(\RectorPrefix20210212\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    public function changeUnderscoreType(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \PhpParser\Node $node, \Rector\Renaming\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace) : void
    {
        $attributeAwarePhpDocNode = $phpDocInfo->getPhpDocNode();
        $phpParserNode = $node;
        $this->phpDocNodeTraverser->traverseWithCallable($attributeAwarePhpDocNode, '', function (\PHPStan\PhpDocParser\Ast\Node $node) use($pseudoNamespaceToNamespace, $phpParserNode, $phpDocInfo) : PhpDocParserNode {
            if (!$node instanceof \PHPStan\PhpDocParser\Ast\Type\TypeNode) {
                return $node;
            }
            if ($this->shouldSkip($node, $phpParserNode, $pseudoNamespaceToNamespace)) {
                return $node;
            }
            /** @var IdentifierTypeNode $node */
            $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($node, $phpParserNode);
            if (!$staticType instanceof \PHPStan\Type\ObjectType) {
                return $node;
            }
            // change underscore to \\
            $slashedName = '\\' . \RectorPrefix20210212\Nette\Utils\Strings::replace($staticType->getClassName(), '#_#', '\\');
            $node->name = $slashedName;
            $phpDocInfo->markAsChanged();
            return $node;
        });
    }
    private function shouldSkip(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $phpParserNode, \Rector\Renaming\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace) : bool
    {
        if (!$typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return \true;
        }
        $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, $phpParserNode);
        if (!$staticType instanceof \PHPStan\Type\ObjectType) {
            return \true;
        }
        if (!\RectorPrefix20210212\Nette\Utils\Strings::startsWith($staticType->getClassName(), $pseudoNamespaceToNamespace->getNamespacePrefix())) {
            return \true;
        }
        // excluded?
        return \in_array($staticType->getClassName(), $pseudoNamespaceToNamespace->getExcludedClasses(), \true);
    }
}
