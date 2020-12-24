<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Sensio\TypeDeclaration;

use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoManipulator;
use _PhpScopere8e811afab72\Rector\Core\Php\PhpVersionProvider;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
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
     * @var PhpDocInfoManipulator
     */
    private $phpDocInfoManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoManipulator $phpDocInfoManipulator, \_PhpScopere8e811afab72\Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->phpVersionProvider = $phpVersionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->phpDocInfoManipulator = $phpDocInfoManipulator;
    }
    public function updateClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $className) : void
    {
        $this->updatePhpDoc($classMethod, $className);
        $this->updatePhp($classMethod, $className);
    }
    private function updatePhpDoc(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $className) : void
    {
        /** @var ReturnTagValueNode|null $returnTagValueNode */
        $returnTagValueNode = $this->phpDocInfoManipulator->getPhpDocTagValueNode($classMethod, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
        if ($returnTagValueNode === null) {
            return;
        }
        $returnStaticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($returnTagValueNode->type, $classMethod);
        if ($returnStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType || $returnStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            $returnTagValueNode->type = new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode($className);
        }
    }
    private function updatePhp(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $className) : void
    {
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return;
        }
        // change return type
        if ($classMethod->returnType !== null) {
            $returnTypeName = $this->nodeNameResolver->getName($classMethod->returnType);
            if ($returnTypeName !== null && \is_a($returnTypeName, $className, \true)) {
                return;
            }
        }
        $classMethod->returnType = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($className);
    }
}
