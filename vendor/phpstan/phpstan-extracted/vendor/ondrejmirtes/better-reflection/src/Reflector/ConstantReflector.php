<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use function assert;
class ConstantReflector implements \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var ClassReflector */
    private $classReflector;
    public function __construct(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector $classReflector)
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
    public function reflect(string $constantName) : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        $identifier = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier($constantName, new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CONSTANT));
        $constantInfo = $this->sourceLocator->locateIdentifier($this->classReflector, $identifier);
        \assert($constantInfo instanceof \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant || $constantInfo === null);
        if ($constantInfo === null) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
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
        $allConstants = $this->sourceLocator->locateIdentifiersByType($this, new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CONSTANT));
        return $allConstants;
    }
}
