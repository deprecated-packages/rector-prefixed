<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject;

use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
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
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\Type $valueType, int $arrayNestingLevel, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $keyType = null)
    {
        $this->type = $valueType;
        $this->arrayNestingLevel = $arrayNestingLevel;
        $this->keyType = $keyType;
    }
    public function getType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getArrayNestingLevel() : int
    {
        return $this->arrayNestingLevel;
    }
    public function getKeyType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->keyType ?: new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
}
