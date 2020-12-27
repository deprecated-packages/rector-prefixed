<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class VariableTypeHolder
{
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var \PHPStan\TrinaryLogic */
    private $certainty;
    public function __construct(\PHPStan\Type\Type $type, \RectorPrefix20201227\PHPStan\TrinaryLogic $certainty)
    {
        $this->type = $type;
        $this->certainty = $certainty;
    }
    public static function createYes(\PHPStan\Type\Type $type) : self
    {
        return new self($type, \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes());
    }
    public static function createMaybe(\PHPStan\Type\Type $type) : self
    {
        return new self($type, \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe());
    }
    public function equals(self $other) : bool
    {
        if (!$this->certainty->equals($other->certainty)) {
            return \false;
        }
        return $this->type->equals($other->type);
    }
    public function and(self $other) : self
    {
        if ($this->getType()->equals($other->getType())) {
            $type = $this->getType();
        } else {
            $type = \PHPStan\Type\TypeCombinator::union($this->getType(), $other->getType());
        }
        return new self($type, $this->getCertainty()->and($other->getCertainty()));
    }
    public function getType() : \PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getCertainty() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->certainty;
    }
}
