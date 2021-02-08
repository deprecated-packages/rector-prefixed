<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode;
use Rector\Core\NodeManipulator\AssignManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeFactory;
use Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeResolver;
use Rector\DoctrineCodeQuality\PhpDoc\CollectionVarTagValueNodeResolver;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\Property\ImproveDoctrineCollectionDocTypeInEntityRector\ImproveDoctrineCollectionDocTypeInEntityRectorTest
 */
final class ImproveDoctrineCollectionDocTypeInEntityRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var CollectionTypeFactory
     */
    private $collectionTypeFactory;
    /**
     * @var AssignManipulator
     */
    private $assignManipulator;
    /**
     * @var CollectionTypeResolver
     */
    private $collectionTypeResolver;
    /**
     * @var CollectionVarTagValueNodeResolver
     */
    private $collectionVarTagValueNodeResolver;
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    public function __construct(\Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeFactory $collectionTypeFactory, \Rector\Core\NodeManipulator\AssignManipulator $assignManipulator, \Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeResolver $collectionTypeResolver, \Rector\DoctrineCodeQuality\PhpDoc\CollectionVarTagValueNodeResolver $collectionVarTagValueNodeResolver, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger, \Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver)
    {
        $this->collectionTypeFactory = $collectionTypeFactory;
        $this->assignManipulator = $assignManipulator;
        $this->collectionTypeResolver = $collectionTypeResolver;
        $this->collectionVarTagValueNodeResolver = $collectionVarTagValueNodeResolver;
        $this->phpDocTypeChanger = $phpDocTypeChanger;
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Improve @var, @param and @return types for Doctrine collections to make them useful both for PHPStan and PHPStorm', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SomeClass
{
    /**
     * @ORM\OneToMany(targetEntity=Training::class, mappedBy="trainer")
     * @var Collection|Trainer[]
     */
    private $trainings = [];
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SomeClass
{
    /**
     * @ORM\OneToMany(targetEntity=Training::class, mappedBy="trainer")
     * @var Collection<int, Training>|Trainer[]
     */
    private $trainings = [];
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Property::class, \PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param Property|ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Stmt\Property) {
            return $this->refactorProperty($node);
        }
        return $this->refactorClassMethod($node);
    }
    private function refactorProperty(\PhpParser\Node\Stmt\Property $property) : ?\PhpParser\Node\Stmt\Property
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        if (!$phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode::class)) {
            return null;
        }
        $attributeAwareVarTagValueNode = $this->collectionVarTagValueNodeResolver->resolve($property);
        if ($attributeAwareVarTagValueNode !== null) {
            $collectionObjectType = $this->collectionTypeResolver->resolveFromTypeNode($attributeAwareVarTagValueNode->type, $property);
            if (!$collectionObjectType instanceof \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType) {
                return null;
            }
            $newVarType = $this->collectionTypeFactory->createType($collectionObjectType);
            $this->phpDocTypeChanger->changeVarType($phpDocInfo, $newVarType);
        } else {
            $collectionObjectType = $this->collectionTypeResolver->resolveFromOneToManyProperty($property);
            if (!$collectionObjectType instanceof \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType) {
                return null;
            }
            $newVarType = $this->collectionTypeFactory->createType($collectionObjectType);
            $this->phpDocTypeChanger->changeVarType($phpDocInfo, $newVarType);
        }
        return $property;
    }
    private function refactorClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        if (!$this->doctrineDocBlockResolver->isInDoctrineEntityClass($classMethod)) {
            return null;
        }
        if (!$classMethod->isPublic()) {
            return null;
        }
        $collectionObjectType = $this->resolveCollectionSetterAssignType($classMethod);
        if (!$collectionObjectType instanceof \PHPStan\Type\Type) {
            return null;
        }
        if (\count($classMethod->params) !== 1) {
            return null;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $param = $classMethod->params[0];
        $parameterName = $this->getName($param);
        $this->phpDocTypeChanger->changeParamType($phpDocInfo, $collectionObjectType, $param, $parameterName);
        return $classMethod;
    }
    private function resolveCollectionSetterAssignType(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PHPStan\Type\Type
    {
        $propertyFetches = $this->assignManipulator->resolveAssignsToLocalPropertyFetches($classMethod);
        if (\count($propertyFetches) !== 1) {
            return null;
        }
        if (!$propertyFetches[0] instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        $property = $this->nodeRepository->findPropertyByPropertyFetch($propertyFetches[0]);
        if (!$property instanceof \PhpParser\Node\Stmt\Property) {
            return null;
        }
        $varTagValueNode = $this->collectionVarTagValueNodeResolver->resolve($property);
        if (!$varTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode) {
            return null;
        }
        return $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($varTagValueNode->type, $property);
    }
}
