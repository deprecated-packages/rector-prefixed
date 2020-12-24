<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use DateTimeInterface;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
final class DoctrineColumnPropertyTypeInferer implements \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var Type[]
     *
     * @see \Doctrine\DBAL\Platforms\MySqlPlatform::initializeDoctrineTypeMappings()
     * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/basic-mapping.html#doctrine-mapping-types
     */
    private $doctrineTypeToScalarType = [];
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
        $this->doctrineTypeToScalarType = [
            'tinyint' => new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType(),
            // integers
            'smallint' => new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(),
            'mediumint' => new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(),
            'int' => new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(),
            'integer' => new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(),
            'bigint' => new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(),
            'numeric' => new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(),
            // floats
            'decimal' => new \_PhpScopere8e811afab72\PHPStan\Type\FloatType(),
            'float' => new \_PhpScopere8e811afab72\PHPStan\Type\FloatType(),
            'double' => new \_PhpScopere8e811afab72\PHPStan\Type\FloatType(),
            'real' => new \_PhpScopere8e811afab72\PHPStan\Type\FloatType(),
            // strings
            'tinytext' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'mediumtext' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'longtext' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'text' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'varchar' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'string' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'char' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'longblob' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'blob' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'mediumblob' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'tinyblob' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'binary' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'varbinary' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            'set' => new \_PhpScopere8e811afab72\PHPStan\Type\StringType(),
            // date time objects
            'date' => new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'datetime' => new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'timestamp' => new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'time' => new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'year' => new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\DateTimeInterface::class),
        ];
    }
    public function inferProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $doctrineColumnTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class);
        if ($doctrineColumnTagValueNode === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $type = $doctrineColumnTagValueNode->getType();
        if ($type === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $scalarType = $this->doctrineTypeToScalarType[$type] ?? null;
        if ($scalarType === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $types = [$scalarType];
        // is nullable?
        if ($doctrineColumnTagValueNode->isNullable()) {
            $types[] = new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    public function getPriority() : int
    {
        return 2000;
    }
}
