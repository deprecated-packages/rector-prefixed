<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\PhpDoc;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class CollectionVarTagValueNodeResolver
{
    /**
     * @var DoctrinePropertyAnalyzer
     */
    private $doctrinePropertyAnalyzer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer $doctrinePropertyAnalyzer)
    {
        $this->doctrinePropertyAnalyzer = $doctrinePropertyAnalyzer;
    }
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode
    {
        $doctrineOneToManyTagValueNode = $this->doctrinePropertyAnalyzer->matchDoctrineOneToManyTagValueNode($property);
        if ($doctrineOneToManyTagValueNode === null) {
            return null;
        }
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return null;
        }
        return $phpDocInfo->getVarTagValueNode();
    }
}
