<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Constant;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class ConstantArrayTypeAndMethod
{
    /** @var \PHPStan\Type\Type|null */
    private $type;
    /** @var string|null */
    private $method;
    /** @var TrinaryLogic */
    private $certainty;
    private function __construct(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?string $method, \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic $certainty)
    {
        $this->type = $type;
        $this->method = $method;
        $this->certainty = $certainty;
    }
    public static function createConcrete(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, string $method, \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic $certainty) : self
    {
        if ($certainty->no()) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        return new self($type, $method, $certainty);
    }
    public static function createUnknown() : self
    {
        return new self(null, null, \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isUnknown() : bool
    {
        return $this->type === null;
    }
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($this->type === null) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        return $this->type;
    }
    public function getMethod() : string
    {
        if ($this->method === null) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        return $this->method;
    }
    public function getCertainty() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->certainty;
    }
}
