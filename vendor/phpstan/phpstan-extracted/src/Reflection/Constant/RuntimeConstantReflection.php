<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Constant;

use _PhpScopere8e811afab72\PHPStan\Reflection\GlobalConstantReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class RuntimeConstantReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\GlobalConstantReflection
{
    /** @var string */
    private $name;
    /** @var Type */
    private $valueType;
    /** @var string|null */
    private $fileName;
    public function __construct(string $name, \_PhpScopere8e811afab72\PHPStan\Type\Type $valueType, ?string $fileName)
    {
        $this->name = $name;
        $this->valueType = $valueType;
        $this->fileName = $fileName;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getValueType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->valueType;
    }
    public function getFileName() : ?string
    {
        return $this->fileName;
    }
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
}
