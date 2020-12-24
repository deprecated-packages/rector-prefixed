<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\PhpDocParser;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddableTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector)
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
    }
    /**
     * @param Class_|string|mixed $class
     */
    public function isDoctrineEntityClass($class) : bool
    {
        if ($class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return $this->isDoctrineEntityClassNode($class);
        }
        if (\is_string($class)) {
            return $this->isStringClassEntity($class);
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
    }
    public function isDoctrineEntityClassWithIdProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if (!$this->isDoctrineEntityClass($class)) {
            return \false;
        }
        foreach ($class->stmts as $classStmt) {
            if (!$classStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property) {
                continue;
            }
            if ($this->hasPropertyDoctrineIdTag($classStmt)) {
                return \true;
            }
        }
        return \false;
    }
    public function getTargetEntity(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : ?string
    {
        $doctrineRelationTagValueNode = $this->getDoctrineRelationTagValueNode($property);
        if ($doctrineRelationTagValueNode === null) {
            return null;
        }
        return $doctrineRelationTagValueNode->getTargetEntity();
    }
    public function getDoctrineRelationTagValueNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface
    {
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        return $phpDocInfo->getByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
    }
    public function isDoctrineProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool
    {
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        $hasTypeColumnTagValueNode = $phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class);
        if ($hasTypeColumnTagValueNode) {
            return \true;
        }
        return $phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
    }
    public function isInDoctrineEntityClass(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        /** @var ClassLike|null $classLike */
        $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $this->isDoctrineEntityClass($classLike);
    }
    private function isDoctrineEntityClassNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        $phpDocInfo = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        $hasTypeEntityTagValueNode = $phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class);
        if ($hasTypeEntityTagValueNode) {
            return \true;
        }
        return $phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddableTagValueNode::class);
    }
    private function isStringClassEntity(string $class) : bool
    {
        if (!\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($class)) {
            return \false;
        }
        $classNode = $this->parsedNodeCollector->findClass($class);
        if ($classNode !== null) {
            return $this->isDoctrineEntityClass($classNode);
        }
        $reflectionClass = new \ReflectionClass($class);
        // dummy check of 3rd party code without running it
        $docCommentContent = (string) $reflectionClass->getDocComment();
        return (bool) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($docCommentContent, self::ORM_ENTITY_EMBEDDABLE_SHORT_ANNOTATION_REGEX);
    }
    private function hasPropertyDoctrineIdTag(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool
    {
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        return $phpDocInfo ? $phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode::class) : \false;
    }
}
