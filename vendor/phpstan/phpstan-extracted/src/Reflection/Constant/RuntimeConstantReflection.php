<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Constant;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\GlobalConstantReflection;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class RuntimeConstantReflection implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\GlobalConstantReflection
{
    /** @var string */
    private $name;
    /** @var Type */
    private $valueType;
    /** @var string|null */
    private $fileName;
    public function __construct(string $name, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType, ?string $fileName)
    {
        $this->name = $name;
        $this->valueType = $valueType;
        $this->fileName = $fileName;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getValueType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->valueType;
    }
    public function getFileName() : ?string
    {
        return $this->fileName;
    }
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
}
