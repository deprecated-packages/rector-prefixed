<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector;

use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionFunction;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use function assert;
class FunctionReflector implements \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\Reflector
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var ClassReflector */
    private $classReflector;
    public function __construct(\_PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\ClassReflector $classReflector)
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
    public function reflect(string $functionName) : \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\Reflection
    {
        $identifier = new \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Identifier\Identifier($functionName, new \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_FUNCTION));
        $functionInfo = $this->sourceLocator->locateIdentifier($this->classReflector, $identifier);
        \assert($functionInfo instanceof \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionFunction || $functionInfo === null);
        if ($functionInfo === null) {
            throw \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
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
        $allFunctions = $this->sourceLocator->locateIdentifiersByType($this, new \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_FUNCTION));
        return $allFunctions;
    }
}
