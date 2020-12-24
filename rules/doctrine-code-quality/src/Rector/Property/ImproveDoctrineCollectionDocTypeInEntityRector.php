<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Property;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeFactory;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeResolver;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\PhpDoc\CollectionVarTagValueNodeResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\Property\ImproveDoctrineCollectionDocTypeInEntityRector\ImproveDoctrineCollectionDocTypeInEntityRectorTest
 */
final class ImproveDoctrineCollectionDocTypeInEntityRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeFactory $collectionTypeFactory, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\PhpDoc\CollectionTypeResolver $collectionTypeResolver, \_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\PhpDoc\CollectionVarTagValueNodeResolver $collectionVarTagValueNodeResolver)
    {
        $this->collectionTypeFactory = $collectionTypeFactory;
        $this->assignManipulator = $assignManipulator;
        $this->collectionTypeResolver = $collectionTypeResolver;
        $this->collectionVarTagValueNodeResolver = $collectionVarTagValueNodeResolver;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Improve @var, @param and @return types for Doctrine collections to make them useful both for PHPStan and PHPStorm', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param Property|ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property) {
            return $this->refactorProperty($node);
        }
        return $this->refactorClassMethod($node);
    }
    private function refactorProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property
    {
        if (!$this->hasNodeTagValueNode($property, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\OneToManyTagValueNode::class)) {
            return null;
        }
        // @todo make an own local property on enter node?
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
    private function refactorClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
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
        if (\count((array) $classMethod->params) !== 1) {
            return null;
        }
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $param = $classMethod->params[0];
        $parameterName = $this->getName($param);
        $phpDocInfo->changeParamType($collectionObjectType, $param, $parameterName);
        return $classMethod;
    }
    private function hasNodeTagValueNode(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, string $tagValueNodeClass) : bool
    {
        $phpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return \false;
        }
        return $phpDocInfo->hasByType($tagValueNodeClass);
    }
    private function resolveCollectionSetterAssignType(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $propertyFetches = $this->assignManipulator->resolveAssignsToLocalPropertyFetches($classMethod);
        if (\count($propertyFetches) !== 1) {
            return null;
        }
        if (!$propertyFetches[0] instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
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
    private function matchPropertyFetchToClassProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property
    {
        $propertyName = $this->getName($propertyFetch);
        if ($propertyName === null) {
            return null;
        }
        $classLike = $propertyFetch->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        return $classLike->getProperty($propertyName);
    }
}
