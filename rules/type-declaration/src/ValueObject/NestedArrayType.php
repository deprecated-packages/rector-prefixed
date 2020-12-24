<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
final class NestedArrayType
{
    /**
     * @var int
     */
    private $arrayNestingLevel;
    /**
     * @var Type
     */
    private $type;
    /**
     * @var Type|null
     */
    private $keyType;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $valueType, int $arrayNestingLevel, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $keyType = null)
    {
        $this->type = $valueType;
        $this->arrayNestingLevel = $arrayNestingLevel;
        $this->keyType = $keyType;
    }
    public function getType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getArrayNestingLevel() : int
    {
        return $this->arrayNestingLevel;
    }
    public function getKeyType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->keyType ?: new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
    }
}
