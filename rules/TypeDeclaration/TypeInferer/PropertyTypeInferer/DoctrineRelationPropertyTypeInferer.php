<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\PhpDocParser\ClassAnnotationMatcher;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use Rector\TypeDeclaration\PhpDoc\ShortClassExpander;
final class DoctrineRelationPropertyTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var string
     */
    private const COLLECTION_TYPE = 'Doctrine\\Common\\Collections\\Collection';
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var ShortClassExpander
     */
    private $shortClassExpander;
    /**
     * @var ClassAnnotationMatcher
     */
    private $classAnnotationMatcher;
    public function __construct(\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\TypeDeclaration\PhpDoc\ShortClassExpander $shortClassExpander, \Rector\BetterPhpDocParser\PhpDocParser\ClassAnnotationMatcher $classAnnotationMatcher)
    {
        $this->typeFactory = $typeFactory;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->shortClassExpander = $shortClassExpander;
        $this->classAnnotationMatcher = $classAnnotationMatcher;
    }
    public function inferProperty(\PhpParser\Node\Stmt\Property $property) : \PHPStan\Type\Type
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $toManyRelationTagValueNode = $phpDocInfo->getByAnnotationClasses(['Doctrine\\ORM\\Mapping\\OneToMany', 'Doctrine\\ORM\\Mapping\\ManyToMany']);
        if ($toManyRelationTagValueNode !== null) {
            return $this->processToManyRelation($property, $toManyRelationTagValueNode);
        }
        $toOneRelationTagValueNode = $phpDocInfo->getByAnnotationClasses(['Doctrine\\ORM\\Mapping\\ManyToOne', 'Doctrine\\ORM\\Mapping\\OneToOne']);
        if ($toOneRelationTagValueNode !== null) {
            $joinDoctrineAnnotationTagValueNode = $phpDocInfo->getByAnnotationClass('Doctrine\\ORM\\Mapping\\JoinColumn');
            return $this->processToOneRelation($property, $toOneRelationTagValueNode, $joinDoctrineAnnotationTagValueNode);
        }
        return new \PHPStan\Type\MixedType();
    }
    public function getPriority() : int
    {
        return 2100;
    }
    private function processToManyRelation(\PhpParser\Node\Stmt\Property $property, \Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode $doctrineAnnotationTagValueNode) : \PHPStan\Type\Type
    {
        $types = [];
        $targetEntity = $doctrineAnnotationTagValueNode->getValueWithoutQuotes('targetEntity');
        if ($targetEntity) {
            $entityFullyQualifiedClass = $this->shortClassExpander->resolveFqnTargetEntity($targetEntity, $property);
            $types[] = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($entityFullyQualifiedClass));
        }
        $types[] = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType(self::COLLECTION_TYPE);
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    private function processToOneRelation(\PhpParser\Node\Stmt\Property $property, \Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode $toOneDoctrineAnnotationTagValueNode, ?\Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode $joinDoctrineAnnotationTagValueNode) : \PHPStan\Type\Type
    {
        $targetEntity = $toOneDoctrineAnnotationTagValueNode->getValueWithoutQuotes('targetEntity');
        if ($targetEntity === null) {
            return new \PHPStan\Type\MixedType();
        }
        if (\RectorPrefix20210408\Nette\Utils\Strings::endsWith($targetEntity, '::class')) {
            $targetEntity = \RectorPrefix20210408\Nette\Utils\Strings::before($targetEntity, '::class');
        }
        // resolve to FQN
        $tagFullyQualifiedName = $this->classAnnotationMatcher->resolveTagFullyQualifiedName($targetEntity, $property);
        $types = [];
        $types[] = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($tagFullyQualifiedName);
        if ($this->shouldAddNullType($joinDoctrineAnnotationTagValueNode)) {
            $types[] = new \PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    private function shouldAddNullType(?\Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode $doctrineAnnotationTagValueNode) : bool
    {
        if ($doctrineAnnotationTagValueNode === null) {
            return \true;
        }
        $isNullableValue = $doctrineAnnotationTagValueNode->getValue('nullable');
        return $isNullableValue instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
    }
}
