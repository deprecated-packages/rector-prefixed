<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Constant;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class ConstantArrayTypeAndMethod
{
    /** @var \PHPStan\Type\Type|null */
    private $type;
    /** @var string|null */
    private $method;
    /** @var TrinaryLogic */
    private $certainty;
    private function __construct(?\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?string $method, \_PhpScopere8e811afab72\PHPStan\TrinaryLogic $certainty)
    {
        $this->type = $type;
        $this->method = $method;
        $this->certainty = $certainty;
    }
    public static function createConcrete(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, string $method, \_PhpScopere8e811afab72\PHPStan\TrinaryLogic $certainty) : self
    {
        if ($certainty->no()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return new self($type, $method, $certainty);
    }
    public static function createUnknown() : self
    {
        return new self(null, null, \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isUnknown() : bool
    {
        return $this->type === null;
    }
    public function getType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->type === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return $this->type;
    }
    public function getMethod() : string
    {
        if ($this->method === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return $this->method;
    }
    public function getCertainty() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->certainty;
    }
}
