<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\PhpDoc;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class VarTagValueNodeRenamer
{
    public function renameAssignVarTagVariableName(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $originalName, string $expectedName) : void
    {
        $phpDocInfo = $this->resolvePhpDocInfo($node);
        if ($phpDocInfo === null) {
            return;
        }
        $varTagValueNode = $phpDocInfo->getByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
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
    private function resolvePhpDocInfo(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $expression = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($expression instanceof \_PhpScoperb75b35f52b74\PhpParser\Node) {
            $expressionPhpDocInfo = $expression->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        }
        return $expressionPhpDocInfo ?? $phpDocInfo;
    }
}
