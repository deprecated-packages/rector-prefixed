<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
final class DoctrineDocBlockResolver
{
    /**
     * @var string
     * @see https://regex101.com/r/doLRPw/1
     */
    private const ORM_ENTITY_EMBEDDABLE_SHORT_ANNOTATION_REGEX = '#@ORM\\\\(Entity|Embeddable)#';
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector)
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
    }
    /**
     * @param Class_|string|mixed $class
     */
    public function isDoctrineEntityClass($class) : bool
    {
        if ($class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return $this->isDoctrineEntityClassNode($class);
        }
        if (\is_string($class)) {
            return $this->isStringClassEntity($class);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
    }
    public function isDoctrineEntityClassWithIdProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if (!$this->isDoctrineEntityClass($class)) {
            return \false;
        }
        foreach ($class->stmts as $classStmt) {
            if (!$classStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property) {
                continue;
            }
            if ($this->hasPropertyDoctrineIdTag($classStmt)) {
                return \true;
            }
        }
        return \false;
    }
    public function getTargetEntity(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : ?string
    {
        $doctrineRelationTagValueNode = $this->getDoctrineRelationTagValueNode($property);
        if ($doctrineRelationTagValueNode === null) {
            return null;
        }
        return $doctrineRelationTagValueNode->getTargetEntity();
    }
    public function getDoctrineRelationTagValueNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : ?\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface
    {
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        return $phpDocInfo->getByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
    }
    public function isDoctrineProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        $hasTypeColumnTagValueNode = $phpDocInfo->hasByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class);
        if ($hasTypeColumnTagValueNode) {
            return \true;
        }
        return $phpDocInfo->hasByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
    }
    public function isInDoctrineEntityClass(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        /** @var ClassLike|null $classLike */
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $this->isDoctrineEntityClass($classLike);
    }
    private function isDoctrineEntityClassNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        $phpDocInfo = $class->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        $hasTypeEntityTagValueNode = $phpDocInfo->hasByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class);
        if ($hasTypeEntityTagValueNode) {
            return \true;
        }
        return $phpDocInfo->hasByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddableTagValueNode::class);
    }
    private function isStringClassEntity(string $class) : bool
    {
        if (!\_PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($class)) {
            return \false;
        }
        $classNode = $this->parsedNodeCollector->findClass($class);
        if ($classNode !== null) {
            return $this->isDoctrineEntityClass($classNode);
        }
        $reflectionClass = new \ReflectionClass($class);
        // dummy check of 3rd party code without running it
        $docCommentContent = (string) $reflectionClass->getDocComment();
        return (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($docCommentContent, self::ORM_ENTITY_EMBEDDABLE_SHORT_ANNOTATION_REGEX);
    }
    private function hasPropertyDoctrineIdTag(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        return $phpDocInfo ? $phpDocInfo->hasByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode::class) : \false;
    }
}
