<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use function assert;
class FunctionReflector implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var ClassReflector */
    private $classReflector;
    public function __construct(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector $classReflector)
    {
        $this->sourceLocator = $sourceLocator;
        $this->classReflector = $classReflector;
    }
    /**
     * Create a ReflectionFunction for the specified $functionName.
     *
     * @return ReflectionFunction
     *
     * @throws IdentifierNotFound
     */
    public function reflect(string $functionName) : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        $identifier = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier($functionName, new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_FUNCTION));
        $functionInfo = $this->sourceLocator->locateIdentifier($this->classReflector, $identifier);
        \assert($functionInfo instanceof \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction || $functionInfo === null);
        if ($functionInfo === null) {
            throw \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
        }
        return $functionInfo;
    }
    /**
     * Get all the functions available in the scope specified by the SourceLocator.
     *
     * @return ReflectionFunction[]
     */
    public function getAllFunctions() : array
    {
        /** @var ReflectionFunction[] $allFunctions */
        $allFunctions = $this->sourceLocator->locateIdentifiersByType($this, new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_FUNCTION));
        return $allFunctions;
    }
}
