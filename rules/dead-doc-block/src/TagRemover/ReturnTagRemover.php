<?php

declare (strict_types=1);
namespace Rector\DeadDocBlock\TagRemover;

use PhpParser\Node\FunctionLike;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\DeadDocBlock\DeadReturnTagValueNodeAnalyzer;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class ReturnTagRemover
{
    /**
     * @var DeadReturnTagValueNodeAnalyzer
     */
    private $deadReturnTagValueNodeAnalyzer;
    public function __construct(\Rector\DeadDocBlock\DeadReturnTagValueNodeAnalyzer $deadReturnTagValueNodeAnalyzer)
    {
        $this->deadReturnTagValueNodeAnalyzer = $deadReturnTagValueNodeAnalyzer;
    }
    public function removeReturnTagIfUseless(\PhpParser\Node\FunctionLike $functionLike) : void
    {
        $phpDocInfo = $functionLike->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        // remove existing type
        $attributeAwareReturnTagValueNode = $phpDocInfo->getReturnTagValue();
        if ($attributeAwareReturnTagValueNode === null) {
            return;
        }
        $isReturnTagValueDead = $this->deadReturnTagValueNodeAnalyzer->isDead($attributeAwareReturnTagValueNode, $functionLike);
        if (!$isReturnTagValueDead) {
            return;
        }
        $phpDocInfo->removeTagValueNodeFromNode($attributeAwareReturnTagValueNode);
    }
}
