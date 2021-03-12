<?php

declare (strict_types=1);
namespace Rector\Sensio\TypeDeclaration;

use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ArrayType;
use PHPStan\Type\UnionType;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareReturnTagValueNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\StaticTypeMapper\StaticTypeMapper;
final class ReturnTypeDeclarationUpdater
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->phpVersionProvider = $phpVersionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function updateClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $className) : void
    {
        $this->updatePhpDoc($classMethod, $className);
        $this->updatePhp($classMethod, $className);
    }
    private function updatePhpDoc(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $className) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $attributeAwareReturnTagValueNode = $phpDocInfo->getReturnTagValue();
        if (!$attributeAwareReturnTagValueNode instanceof \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareReturnTagValueNode) {
            return;
        }
        $returnStaticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($attributeAwareReturnTagValueNode->type, $classMethod);
        if ($returnStaticType instanceof \PHPStan\Type\ArrayType || $returnStaticType instanceof \PHPStan\Type\UnionType) {
            $attributeAwareReturnTagValueNode->type = new \Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode($className);
        }
    }
    private function updatePhp(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $className) : void
    {
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return;
        }
        // change return type
        if ($classMethod->returnType !== null) {
            $returnTypeName = $this->nodeNameResolver->getName($classMethod->returnType);
            if ($returnTypeName !== null && \is_a($returnTypeName, $className, \true)) {
                return;
            }
        }
        $classMethod->returnType = new \PhpParser\Node\Name\FullyQualified($className);
    }
}
