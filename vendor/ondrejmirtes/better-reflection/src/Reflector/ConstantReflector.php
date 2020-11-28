<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector;

use _PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionConstant;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use function assert;
class ConstantReflector implements \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\Reflector
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var ClassReflector */
    private $classReflector;
    public function __construct(\_PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\ClassReflector $classReflector)
    {
        $this->sourceLocator = $sourceLocator;
        $this->classReflector = $classReflector;
    }
    /**
     * Create a ReflectionConstant for the specified $constantName.
     *
     * @return ReflectionConstant
     *
     * @throws IdentifierNotFound
     */
    public function reflect(string $constantName) : \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\Reflection
    {
        $identifier = new \_PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\Identifier($constantName, new \_PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CONSTANT));
        $constantInfo = $this->sourceLocator->locateIdentifier($this->classReflector, $identifier);
        \assert($constantInfo instanceof \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionConstant || $constantInfo === null);
        if ($constantInfo === null) {
            throw \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
        }
        return $constantInfo;
    }
    /**
     * Get all the constants available in the scope specified by the SourceLocator.
     *
     * @return array<int, ReflectionConstant>
     */
    public function getAllConstants() : array
    {
        /** @var array<int,ReflectionConstant> $allConstants */
        $allConstants = $this->sourceLocator->locateIdentifiersByType($this, new \_PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CONSTANT));
        return $allConstants;
    }
}
