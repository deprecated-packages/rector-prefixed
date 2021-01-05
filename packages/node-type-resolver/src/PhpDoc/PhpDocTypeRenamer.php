<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PhpDoc;

use RectorPrefix20210105\Nette\Utils\Strings;
use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Node as PhpDocParserNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Generic\ValueObject\PseudoNamespaceToNamespace;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\StaticTypeMapper\StaticTypeMapper;
use RectorPrefix20210105\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
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
    public function __construct(\RectorPrefix20210105\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    public function changeUnderscoreType(\PhpParser\Node $node, \Rector\Generic\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $attributeAwarePhpDocNode = $phpDocInfo->getPhpDocNode();
        $phpParserNode = $node;
        $this->phpDocNodeTraverser->traverseWithCallable($attributeAwarePhpDocNode, '', function (\PHPStan\PhpDocParser\Ast\Node $node) use($pseudoNamespaceToNamespace, $phpParserNode) : PhpDocParserNode {
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
            $slashedName = '\\' . \RectorPrefix20210105\Nette\Utils\Strings::replace($staticType->getClassName(), '#_#', '\\');
            $node->name = $slashedName;
            return $node;
        });
    }
    private function shouldSkip(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $phpParserNode, \Rector\Generic\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace) : bool
    {
        if (!$typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return \true;
        }
        $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, $phpParserNode);
        if (!$staticType instanceof \PHPStan\Type\ObjectType) {
            return \true;
        }
        if (!\RectorPrefix20210105\Nette\Utils\Strings::startsWith($staticType->getClassName(), $pseudoNamespaceToNamespace->getNamespacePrefix())) {
            return \true;
        }
        // excluded?
        return \in_array($staticType->getClassName(), $pseudoNamespaceToNamespace->getExcludedClasses(), \true);
    }
}
