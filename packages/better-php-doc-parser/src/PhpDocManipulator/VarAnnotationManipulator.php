<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocManipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class VarAnnotationManipulator
{
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function decorateNodeWithInlineVarType(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName $typeWithClassName, string $variableName) : void
    {
        $phpDocInfo = $this->resolvePhpDocInfo($node);
        // already done
        if ($phpDocInfo->getVarTagValueNode() !== null) {
            return;
        }
        $fullyQualifiedIdentifierTypeNode = new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode($typeWithClassName->getClassName());
        $attributeAwareVarTagValueNode = new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode($fullyQualifiedIdentifierTypeNode, '$' . $variableName, '');
        $phpDocInfo->addTagValueNode($attributeAwareVarTagValueNode);
    }
    public function decorateNodeWithType(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Type\Type $staticType) : void
    {
        if ($staticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($node);
        }
        $phpDocInfo->changeVarType($staticType);
    }
    private function resolvePhpDocInfo(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $currentStmt = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($currentStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $currentStmt->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        } else {
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        }
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($node);
        }
        $phpDocInfo->makeSingleLined();
        return $phpDocInfo;
    }
}
