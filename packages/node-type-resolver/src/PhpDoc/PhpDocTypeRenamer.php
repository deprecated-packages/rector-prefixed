<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\PhpDoc;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node as PhpDocParserNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\PseudoNamespaceToNamespace;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScopere8e811afab72\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
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
    public function __construct(\_PhpScopere8e811afab72\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    public function changeUnderscoreType(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $attributeAwarePhpDocNode = $phpDocInfo->getPhpDocNode();
        $phpParserNode = $node;
        $this->phpDocNodeTraverser->traverseWithCallable($attributeAwarePhpDocNode, '', function (\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node) use($pseudoNamespaceToNamespace, $phpParserNode) : PhpDocParserNode {
            if (!$node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode) {
                return $node;
            }
            if ($this->shouldSkip($node, $phpParserNode, $pseudoNamespaceToNamespace)) {
                return $node;
            }
            /** @var IdentifierTypeNode $node */
            $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($node, $phpParserNode);
            if (!$staticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
                return $node;
            }
            // change underscore to \\
            $slashedName = '\\' . \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($staticType->getClassName(), '#_#', '\\');
            $node->name = $slashedName;
            return $node;
        });
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScopere8e811afab72\PhpParser\Node $phpParserNode, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace) : bool
    {
        if (!$typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return \true;
        }
        $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, $phpParserNode);
        if (!$staticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return \true;
        }
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::startsWith($staticType->getClassName(), $pseudoNamespaceToNamespace->getNamespacePrefix())) {
            return \true;
        }
        // excluded?
        return \in_array($staticType->getClassName(), $pseudoNamespaceToNamespace->getExcludedClasses(), \true);
    }
}
