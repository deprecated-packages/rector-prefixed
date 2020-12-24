<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PhpDoc;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node as PhpDocParserNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\PseudoNamespaceToNamespace;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoper0a6b37af0871\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
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
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    public function changeUnderscoreType(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $attributeAwarePhpDocNode = $phpDocInfo->getPhpDocNode();
        $phpParserNode = $node;
        $this->phpDocNodeTraverser->traverseWithCallable($attributeAwarePhpDocNode, '', function (\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node $node) use($pseudoNamespaceToNamespace, $phpParserNode) : PhpDocParserNode {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode) {
                return $node;
            }
            if ($this->shouldSkip($node, $phpParserNode, $pseudoNamespaceToNamespace)) {
                return $node;
            }
            /** @var IdentifierTypeNode $node */
            $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($node, $phpParserNode);
            if (!$staticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
                return $node;
            }
            // change underscore to \\
            $slashedName = '\\' . \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($staticType->getClassName(), '#_#', '\\');
            $node->name = $slashedName;
            return $node;
        });
    }
    private function shouldSkip(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a6b37af0871\PhpParser\Node $phpParserNode, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\PseudoNamespaceToNamespace $pseudoNamespaceToNamespace) : bool
    {
        if (!$typeNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return \true;
        }
        $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, $phpParserNode);
        if (!$staticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
            return \true;
        }
        if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::startsWith($staticType->getClassName(), $pseudoNamespaceToNamespace->getNamespacePrefix())) {
            return \true;
        }
        // excluded?
        return \in_array($staticType->getClassName(), $pseudoNamespaceToNamespace->getExcludedClasses(), \true);
    }
}
