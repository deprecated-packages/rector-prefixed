<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use DateTimeInterface;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
final class DoctrineColumnPropertyTypeInferer implements \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
        $this->doctrineTypeToScalarType = [
            'tinyint' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType(),
            // integers
            'smallint' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(),
            'mediumint' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(),
            'int' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(),
            'integer' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(),
            'bigint' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(),
            'numeric' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(),
            // floats
            'decimal' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType(),
            'float' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType(),
            'double' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType(),
            'real' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType(),
            // strings
            'tinytext' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'mediumtext' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'longtext' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'text' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'varchar' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'string' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'char' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'longblob' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'blob' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'mediumblob' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'tinyblob' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'binary' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'varbinary' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            'set' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(),
            // date time objects
            'date' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'datetime' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'timestamp' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'time' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'year' => new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType(\DateTimeInterface::class),
        ];
    }
    public function inferProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        $doctrineColumnTagValueNode = $phpDocInfo->getByType(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class);
        if ($doctrineColumnTagValueNode === null) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        $type = $doctrineColumnTagValueNode->getType();
        if ($type === null) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        $scalarType = $this->doctrineTypeToScalarType[$type] ?? null;
        if ($scalarType === null) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        $types = [$scalarType];
        // is nullable?
        if ($doctrineColumnTagValueNode->isNullable()) {
            $types[] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    public function getPriority() : int
    {
        return 2000;
    }
}
