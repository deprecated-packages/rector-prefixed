<?php

declare (strict_types=1);
namespace Rector\Doctrine\TypeAnalyzer;

use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Doctrine\PhpDoc\Node\Property_\OneToManyTagValueNode;
final class CollectionVarTagValueNodeResolver
{
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function resolve(\PhpParser\Node\Stmt\Property $property) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        if (!$phpDocInfo->hasByType(\Rector\Doctrine\PhpDoc\Node\Property_\OneToManyTagValueNode::class)) {
            return null;
        }
        return $phpDocInfo->getVarTagValueNode();
    }
}
