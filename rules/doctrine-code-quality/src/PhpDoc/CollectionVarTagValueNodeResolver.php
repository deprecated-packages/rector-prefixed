<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\PhpDoc;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class CollectionVarTagValueNodeResolver
{
    /**
     * @var DoctrinePropertyAnalyzer
     */
    private $doctrinePropertyAnalyzer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer $doctrinePropertyAnalyzer)
    {
        $this->doctrinePropertyAnalyzer = $doctrinePropertyAnalyzer;
    }
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode
    {
        $doctrineOneToManyTagValueNode = $this->doctrinePropertyAnalyzer->matchDoctrineOneToManyTagValueNode($property);
        if ($doctrineOneToManyTagValueNode === null) {
            return null;
        }
        $phpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return null;
        }
        return $phpDocInfo->getVarTagValueNode();
    }
}
