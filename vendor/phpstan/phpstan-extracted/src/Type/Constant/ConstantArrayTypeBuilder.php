<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Constant;

use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
use function array_filter;
class ConstantArrayTypeBuilder
{
    /** @var array<int, Type> */
    private $keyTypes;
    /** @var array<int, Type> */
    private $valueTypes;
    /** @var array<int> */
    private $optionalKeys;
    /** @var int */
    private $nextAutoIndex;
    /** @var bool */
    private $degradeToGeneralArray = \false;
    /**
     * @param array<int, ConstantIntegerType|ConstantStringType> $keyTypes
     * @param array<int, Type> $valueTypes
     * @param array<int> $optionalKeys
     * @param int $nextAutoIndex
     */
    private function __construct(array $keyTypes, array $valueTypes, int $nextAutoIndex, array $optionalKeys)
    {
        $this->keyTypes = $keyTypes;
        $this->valueTypes = $valueTypes;
        $this->nextAutoIndex = $nextAutoIndex;
        $this->optionalKeys = $optionalKeys;
    }
    public static function createEmpty() : self
    {
        return new self([], [], 0, []);
    }
    public static function createFromConstantArray(\_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType $startArrayType) : self
    {
        return new self($startArrayType->getKeyTypes(), $startArrayType->getValueTypes(), $startArrayType->getNextAutoIndex(), $startArrayType->getOptionalKeys());
    }
    public function setOffsetValueType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType, bool $optional = \false) : void
    {
        if ($offsetType === null) {
            $offsetType = new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType($this->nextAutoIndex);
        } else {
            $offsetType = \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType::castToArrayKeyType($offsetType);
        }
        if (!$this->degradeToGeneralArray && ($offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType || $offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType)) {
            /** @var ConstantIntegerType|ConstantStringType $keyType */
            foreach ($this->keyTypes as $i => $keyType) {
                if ($keyType->getValue() === $offsetType->getValue()) {
                    $this->valueTypes[$i] = $valueType;
                    $this->optionalKeys = \array_values(\array_filter($this->optionalKeys, static function (int $index) use($i) : bool {
                        return $index !== $i;
                    }));
                    return;
                }
            }
            $this->keyTypes[] = $offsetType;
            $this->valueTypes[] = $valueType;
            if ($optional) {
                $this->optionalKeys[] = \count($this->keyTypes) - 1;
            }
            /** @var int|float $newNextAutoIndex */
            $newNextAutoIndex = $offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType ? \max($this->nextAutoIndex, $offsetType->getValue() + 1) : $this->nextAutoIndex;
            if (!\is_float($newNextAutoIndex)) {
                $this->nextAutoIndex = $newNextAutoIndex;
            }
            return;
        }
        $this->keyTypes[] = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::generalizeType($offsetType);
        $this->valueTypes[] = $valueType;
        $this->degradeToGeneralArray = \true;
    }
    public function degradeToGeneralArray() : void
    {
        $this->degradeToGeneralArray = \true;
    }
    public function getArray() : \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType
    {
        if (!$this->degradeToGeneralArray) {
            /** @var array<int, ConstantIntegerType|ConstantStringType> $keyTypes */
            $keyTypes = $this->keyTypes;
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType($keyTypes, $this->valueTypes, $this->nextAutoIndex, $this->optionalKeys);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$this->keyTypes), \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$this->valueTypes));
    }
}
