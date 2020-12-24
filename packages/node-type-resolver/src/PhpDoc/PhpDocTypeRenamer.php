<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PhpDoc;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node as PhpDocParserNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\PseudoNamespaceToNamespace;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
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
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    public function changeUnderscoreType(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $attributeAwarePhpDocNode = $phpDocInfo->getPhpDocNode();
        $phpParserNode = $node;
        $this->phpDocNodeTraverser->traverseWithCallable($attributeAwarePhpDocNode, '', function (\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node) use($pseudoNamespaceToNamespace, $phpParserNode) : PhpDocParserNode {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode) {
                return $node;
            }
            if ($this->shouldSkip($node, $phpParserNode, $pseudoNamespaceToNamespace)) {
                return $node;
            }
            /** @var IdentifierTypeNode $node */
            $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($node, $phpParserNode);
            if (!$staticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
                return $node;
            }
            // change underscore to \\
            $slashedName = '\\' . \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace($staticType->getClassName(), '#_#', '\\');
            $node->name = $slashedName;
            return $node;
        });
    }
    private function shouldSkip(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoperb75b35f52b74\PhpParser\Node $phpParserNode, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace) : bool
    {
        if (!$typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return \true;
        }
        $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, $phpParserNode);
        if (!$staticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return \true;
        }
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::startsWith($staticType->getClassName(), $pseudoNamespaceToNamespace->getNamespacePrefix())) {
            return \true;
        }
        // excluded?
        return \in_array($staticType->getClassName(), $pseudoNamespaceToNamespace->getExcludedClasses(), \true);
    }
}
