<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use DateTimeInterface;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
final class DoctrineColumnPropertyTypeInferer implements \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
        $this->doctrineTypeToScalarType = [
            'tinyint' => new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType(),
            // integers
            'smallint' => new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(),
            'mediumint' => new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(),
            'int' => new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(),
            'integer' => new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(),
            'bigint' => new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(),
            'numeric' => new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(),
            // floats
            'decimal' => new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType(),
            'float' => new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType(),
            'double' => new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType(),
            'real' => new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType(),
            // strings
            'tinytext' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'mediumtext' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'longtext' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'text' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'varchar' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'string' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'char' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'longblob' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'blob' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'mediumblob' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'tinyblob' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'binary' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'varbinary' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            'set' => new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(),
            // date time objects
            'date' => new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'datetime' => new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'timestamp' => new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'time' => new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\DateTimeInterface::class),
            'year' => new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\DateTimeInterface::class),
        ];
    }
    public function inferProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $doctrineColumnTagValueNode = $phpDocInfo->getByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class);
        if ($doctrineColumnTagValueNode === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $type = $doctrineColumnTagValueNode->getType();
        if ($type === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $scalarType = $this->doctrineTypeToScalarType[$type] ?? null;
        if ($scalarType === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $types = [$scalarType];
        // is nullable?
        if ($doctrineColumnTagValueNode->isNullable()) {
            $types[] = new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    public function getPriority() : int
    {
        return 2000;
    }
}
