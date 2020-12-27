<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser;

use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
class ScopeContext
{
    /** @var string */
    private $file;
    /** @var ClassReflection|null */
    private $classReflection;
    /** @var ClassReflection|null */
    private $traitReflection;
    private function __construct(string $file, ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $traitReflection)
    {
        $this->file = $file;
        $this->classReflection = $classReflection;
        $this->traitReflection = $traitReflection;
    }
    public static function create(string $file) : self
    {
        return new self($file, null, null);
    }
    public function beginFile() : self
    {
        return new self($this->file, null, null);
    }
    public function enterClass(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection) : self
    {
        if ($this->classReflection !== null && !$classReflection->isAnonymous()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        if ($classReflection->isTrait()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return new self($this->file, $classReflection, null);
    }
    public function enterTrait(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $traitReflection) : self
    {
        if ($this->classReflection === null) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        if (!$traitReflection->isTrait()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return new self($this->file, $this->classReflection, $traitReflection);
    }
    public function equals(self $otherContext) : bool
    {
        if ($this->file !== $otherContext->file) {
            return \false;
        }
        if ($this->getClassReflection() === null) {
            return $otherContext->getClassReflection() === null;
        } elseif ($otherContext->getClassReflection() === null) {
            return \false;
        }
        $isSameClass = $this->getClassReflection()->getName() === $otherContext->getClassReflection()->getName();
        if ($this->getTraitReflection() === null) {
            return $otherContext->getTraitReflection() === null && $isSameClass;
        } elseif ($otherContext->getTraitReflection() === null) {
            return \false;
        }
        $isSameTrait = $this->getTraitReflection()->getName() === $otherContext->getTraitReflection()->getName();
        return $isSameClass && $isSameTrait;
    }
    public function getFile() : string
    {
        return $this->file;
    }
    public function getClassReflection() : ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        return $this->classReflection;
    }
    public function getTraitReflection() : ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        return $this->traitReflection;
    }
}
