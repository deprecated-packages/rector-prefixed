<?php

declare (strict_types=1);
namespace Rector\Naming\PhpDoc;

use PhpParser\Node;
use PhpParser\Node\Stmt\Expression;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class VarTagValueNodeRenamer
{
    public function renameAssignVarTagVariableName(\PhpParser\Node $node, string $originalName, string $expectedName) : void
    {
        $phpDocInfo = $this->resolvePhpDocInfo($node);
        if ($phpDocInfo === null) {
            return;
        }
        $varTagValueNode = $phpDocInfo->getVarTagValueNode();
        if (!$varTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode) {
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
    private function resolvePhpDocInfo(\PhpParser\Node $node) : ?\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $expression = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($expression instanceof \PhpParser\Node) {
            $expressionPhpDocInfo = $expression->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        }
        return $expressionPhpDocInfo ?? $phpDocInfo;
    }
}
