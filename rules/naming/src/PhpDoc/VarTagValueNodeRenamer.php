<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\PhpDoc;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class VarTagValueNodeRenamer
{
    public function renameAssignVarTagVariableName(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $originalName, string $expectedName) : void
    {
        $phpDocInfo = $this->resolvePhpDocInfo($node);
        if ($phpDocInfo === null) {
            return;
        }
        $varTagValueNode = $phpDocInfo->getByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
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
    private function resolvePhpDocInfo(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $expression = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($expression instanceof \_PhpScoper0a6b37af0871\PhpParser\Node) {
            $expressionPhpDocInfo = $expression->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        }
        return $expressionPhpDocInfo ?? $phpDocInfo;
    }
}
