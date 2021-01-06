<?php

declare (strict_types=1);
namespace Rector\Doctrine\PhpDocParser;

use RectorPrefix20210106\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddableTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector)
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
    }
    /**
     * @param Class_|string|mixed $class
     */
    public function isDoctrineEntityClass($class) : bool
    {
        if ($class instanceof \PhpParser\Node\Stmt\Class_) {
            return $this->isDoctrineEntityClassNode($class);
        }
        if (\is_string($class)) {
            return $this->isStringClassEntity($class);
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException();
    }
    public function isDoctrineEntityClassWithIdProperty(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if (!$this->isDoctrineEntityClass($class)) {
            return \false;
        }
        foreach ($class->stmts as $classStmt) {
            if (!$classStmt instanceof \PhpParser\Node\Stmt\Property) {
                continue;
            }
            if ($this->hasPropertyDoctrineIdTag($classStmt)) {
                return \true;
            }
        }
        return \false;
    }
    public function getTargetEntity(\PhpParser\Node\Stmt\Property $property) : ?string
    {
        $doctrineRelationTagValueNode = $this->getDoctrineRelationTagValueNode($property);
        if ($doctrineRelationTagValueNode === null) {
            return null;
        }
        return $doctrineRelationTagValueNode->getTargetEntity();
    }
    public function getDoctrineRelationTagValueNode(\PhpParser\Node\Stmt\Property $property) : ?\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface
    {
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        return $phpDocInfo->getByType(\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
    }
    public function isDoctrineProperty(\PhpParser\Node\Stmt\Property $property) : bool
    {
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        $hasTypeColumnTagValueNode = $phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class);
        if ($hasTypeColumnTagValueNode) {
            return \true;
        }
        return $phpDocInfo->hasByType(\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
    }
    public function isInDoctrineEntityClass(\PhpParser\Node $node) : bool
    {
        /** @var ClassLike|null $classLike */
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $this->isDoctrineEntityClass($classLike);
    }
    private function isDoctrineEntityClassNode(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        $phpDocInfo = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        $hasTypeEntityTagValueNode = $phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class);
        if ($hasTypeEntityTagValueNode) {
            return \true;
        }
        return $phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddableTagValueNode::class);
    }
    private function isStringClassEntity(string $class) : bool
    {
        if (!\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($class)) {
            return \false;
        }
        $classNode = $this->parsedNodeCollector->findClass($class);
        if ($classNode !== null) {
            return $this->isDoctrineEntityClass($classNode);
        }
        $reflectionClass = new \ReflectionClass($class);
        // dummy check of 3rd party code without running it
        $docCommentContent = (string) $reflectionClass->getDocComment();
        return (bool) \RectorPrefix20210106\Nette\Utils\Strings::match($docCommentContent, self::ORM_ENTITY_EMBEDDABLE_SHORT_ANNOTATION_REGEX);
    }
    private function hasPropertyDoctrineIdTag(\PhpParser\Node\Stmt\Property $property) : bool
    {
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        return $phpDocInfo ? $phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode::class) : \false;
    }
}
