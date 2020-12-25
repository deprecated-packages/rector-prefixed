<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode;
use Rector\Core\PhpParser\Node\Manipulator\AssignManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeFactory;
use Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeResolver;
use Rector\DoctrineCodeQuality\PhpDoc\CollectionVarTagValueNodeResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeFactory $collectionTypeFactory, \Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeResolver $collectionTypeResolver, \Rector\DoctrineCodeQuality\PhpDoc\CollectionVarTagValueNodeResolver $collectionVarTagValueNodeResolver)
    {
        $this->collectionTypeFactory = $collectionTypeFactory;
        $this->assignManipulator = $assignManipulator;
        $this->collectionTypeResolver = $collectionTypeResolver;
        $this->collectionVarTagValueNodeResolver = $collectionVarTagValueNodeResolver;
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
        if (!$this->hasNodeTagValueNode($property, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode::class)) {
            return null;
        }
        // @todo make an own local property on enter node?
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $attributeAwareVarTagValueNode = $this->collectionVarTagValueNodeResolver->resolve($property);
        if ($attributeAwareVarTagValueNode !== null) {
            $collectionObjectType = $this->collectionTypeResolver->resolveFromTypeNode($attributeAwareVarTagValueNode->type, $property);
            if ($collectionObjectType === null) {
                return null;
            }
            $newVarType = $this->collectionTypeFactory->createType($collectionObjectType);
            $phpDocInfo->changeVarType($newVarType);
        } else {
            $collectionObjectType = $this->collectionTypeResolver->resolveFromOneToManyProperty($property);
            if ($collectionObjectType === null) {
                return null;
            }
            $newVarType = $this->collectionTypeFactory->createType($collectionObjectType);
            $phpDocInfo->changeVarType($newVarType);
        }
        return $property;
    }
    private function refactorClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        if (!$this->isInDoctrineEntityClass($classMethod)) {
            return null;
        }
        if (!$classMethod->isPublic()) {
            return null;
        }
        $collectionObjectType = $this->resolveCollectionSetterAssignType($classMethod);
        if ($collectionObjectType === null) {
            return null;
        }
        if (\count($classMethod->params) !== 1) {
            return null;
        }
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $param = $classMethod->params[0];
        $parameterName = $this->getName($param);
        $phpDocInfo->changeParamType($collectionObjectType, $param, $parameterName);
        return $classMethod;
    }
    private function hasNodeTagValueNode(\PhpParser\Node\Stmt\Property $property, string $tagValueNodeClass) : bool
    {
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return \false;
        }
        return $phpDocInfo->hasByType($tagValueNodeClass);
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
        $property = $this->matchPropertyFetchToClassProperty($propertyFetches[0]);
        if ($property === null) {
            return null;
        }
        $varTagValueNode = $this->collectionVarTagValueNodeResolver->resolve($property);
        if ($varTagValueNode === null) {
            return null;
        }
        return $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($varTagValueNode->type, $property);
    }
    private function matchPropertyFetchToClassProperty(\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\PhpParser\Node\Stmt\Property
    {
        $propertyName = $this->getName($propertyFetch);
        if ($propertyName === null) {
            return null;
        }
        $classLike = $propertyFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        return $classLike->getProperty($propertyName);
    }
}
