<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\PhpDoc;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class VarTagValueNodeRenamer
{
    public function renameAssignVarTagVariableName(\_PhpScopere8e811afab72\PhpParser\Node $node, string $originalName, string $expectedName) : void
    {
        $phpDocInfo = $this->resolvePhpDocInfo($node);
        if ($phpDocInfo === null) {
            return;
        }
        $varTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
        if ($varTagValueNode === null) {
            return;
        }
        if ($varTagValueNode->variableName !== '$' . $originalName) {
            return;
        }
        $varTagValueNode->variableName = '$' . $expectedName;
    }
    /**
     * Expression doc block has higher priority
     */
    private function resolvePhpDocInfo(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $expression = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($expression instanceof \_PhpScopere8e811afab72\PhpParser\Node) {
            $expressionPhpDocInfo = $expression->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        }
        return $expressionPhpDocInfo ?? $phpDocInfo;
    }
}
