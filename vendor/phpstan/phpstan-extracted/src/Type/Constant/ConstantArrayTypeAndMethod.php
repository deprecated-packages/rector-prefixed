<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Constant;

use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
class ConstantArrayTypeAndMethod
{
    /** @var \PHPStan\Type\Type|null */
    private $type;
    /** @var string|null */
    private $method;
    /** @var TrinaryLogic */
    private $certainty;
    private function __construct(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, ?string $method, \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic $certainty)
    {
        $this->type = $type;
        $this->method = $method;
        $this->certainty = $certainty;
    }
    public static function createConcrete(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, string $method, \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic $certainty) : self
    {
        if ($certainty->no()) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        return new self($type, $method, $certainty);
    }
    public static function createUnknown() : self
    {
        return new self(null, null, \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isUnknown() : bool
    {
        return $this->type === null;
    }
    public function getType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->type === null) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        return $this->type;
    }
    public function getMethod() : string
    {
        if ($this->method === null) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        return $this->method;
    }
    public function getCertainty() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->certainty;
    }
}
