<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject;

use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
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
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType, int $arrayNestingLevel, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $keyType = null)
    {
        $this->type = $valueType;
        $this->arrayNestingLevel = $arrayNestingLevel;
        $this->keyType = $keyType;
    }
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getArrayNestingLevel() : int
    {
        return $this->arrayNestingLevel;
    }
    public function getKeyType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->keyType ?: new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
}
