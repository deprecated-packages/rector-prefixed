<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\PhpParser;

use PhpParser\Node;
use PhpParser\Node\Name;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StaticType;
use PHPStan\Type\StringType;
use PHPStan\Type\ThisType;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PSR4\Collector\RenamedClassesCollector;
use Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
use Rector\StaticTypeMapper\ValueObject\Type\FalseBooleanType;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class NameNodeMapper implements \Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    public function __construct(\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector)
    {
        $this->renamedClassesCollector = $renamedClassesCollector;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Name::class;
    }
    /**
     * @param Name $node
     */
    public function mapToPHPStan(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        $name = $node->toString();
        if ($this->isExistingClass($name)) {
            return new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($name);
        }
        if (\in_array($name, ['static', 'self'], \true)) {
            return $this->createClassReferenceType($node, $name);
        }
        return $this->createScalarType($name);
    }
    private function isExistingClass(string $name) : bool
    {
        if (\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($name)) {
            return \true;
        }
        // to be existing class names
        $oldToNewClasses = $this->renamedClassesCollector->getOldToNewClasses();
        return \in_array($name, $oldToNewClasses, \true);
    }
    private function createClassReferenceType(\PhpParser\Node\Name $name, string $reference) : \PHPStan\Type\Type
    {
        $className = $name->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return new \PHPStan\Type\MixedType();
        }
        if ($reference === 'static') {
            return new \PHPStan\Type\StaticType($className);
        }
        return new \PHPStan\Type\ThisType($className);
    }
    private function createScalarType(string $name) : \PHPStan\Type\Type
    {
        if ($name === 'array') {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        }
        if ($name === 'int') {
            return new \PHPStan\Type\IntegerType();
        }
        if ($name === 'float') {
            return new \PHPStan\Type\FloatType();
        }
        if ($name === 'string') {
            return new \PHPStan\Type\StringType();
        }
        if ($name === 'false') {
            return new \Rector\StaticTypeMapper\ValueObject\Type\FalseBooleanType();
        }
        if ($name === 'bool') {
            return new \PHPStan\Type\BooleanType();
        }
        return new \PHPStan\Type\MixedType();
    }
}
