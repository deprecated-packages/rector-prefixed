<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\PhpDoc;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class CollectionVarTagValueNodeResolver
{
    /**
     * @var DoctrinePropertyAnalyzer
     */
    private $doctrinePropertyAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer $doctrinePropertyAnalyzer)
    {
        $this->doctrinePropertyAnalyzer = $doctrinePropertyAnalyzer;
    }
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode
    {
        $doctrineOneToManyTagValueNode = $this->doctrinePropertyAnalyzer->matchDoctrineOneToManyTagValueNode($property);
        if ($doctrineOneToManyTagValueNode === null) {
            return null;
        }
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return null;
        }
        return $phpDocInfo->getVarTagValueNode();
    }
}
