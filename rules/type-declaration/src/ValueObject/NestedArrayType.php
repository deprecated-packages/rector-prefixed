<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject;

use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
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
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $valueType, int $arrayNestingLevel, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $keyType = null)
    {
        $this->type = $valueType;
        $this->arrayNestingLevel = $arrayNestingLevel;
        $this->keyType = $keyType;
    }
    public function getType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getArrayNestingLevel() : int
    {
        return $this->arrayNestingLevel;
    }
    public function getKeyType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->keyType ?: new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
}
