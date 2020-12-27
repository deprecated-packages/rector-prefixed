<?php

declare (strict_types=1);
namespace PHPStan\Type\Constant;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class ConstantArrayTypeAndMethod
{
    /** @var \PHPStan\Type\Type|null */
    private $type;
    /** @var string|null */
    private $method;
    /** @var TrinaryLogic */
    private $certainty;
    private function __construct(?\PHPStan\Type\Type $type, ?string $method, \RectorPrefix20201227\PHPStan\TrinaryLogic $certainty)
    {
        $this->type = $type;
        $this->method = $method;
        $this->certainty = $certainty;
    }
    public static function createConcrete(\PHPStan\Type\Type $type, string $method, \RectorPrefix20201227\PHPStan\TrinaryLogic $certainty) : self
    {
        if ($certainty->no()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return new self($type, $method, $certainty);
    }
    public static function createUnknown() : self
    {
        return new self(null, null, \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isUnknown() : bool
    {
        return $this->type === null;
    }
    public function getType() : \PHPStan\Type\Type
    {
        if ($this->type === null) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return $this->type;
    }
    public function getMethod() : string
    {
        if ($this->method === null) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return $this->method;
    }
    public function getCertainty() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->certainty;
    }
}
