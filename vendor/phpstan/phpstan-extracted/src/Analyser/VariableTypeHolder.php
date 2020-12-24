<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Analyser;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
class VariableTypeHolder
{
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var \PHPStan\TrinaryLogic */
    private $certainty;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic $certainty)
    {
        $this->type = $type;
        $this->certainty = $certainty;
    }
    public static function createYes(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : self
    {
        return new self($type, \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createYes());
    }
    public static function createMaybe(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : self
    {
        return new self($type, \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe());
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
            $type = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union($this->getType(), $other->getType());
        }
        return new self($type, $this->getCertainty()->and($other->getCertainty()));
    }
    public function getType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getCertainty() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return $this->certainty;
    }
}
