<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector;

use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionFunction;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use function assert;
class FunctionReflector implements \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var ClassReflector */
    private $classReflector;
    public function __construct(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\ClassReflector $classReflector)
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
    public function reflect(string $functionName) : \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection
    {
        $identifier = new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier($functionName, new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_FUNCTION));
        $functionInfo = $this->sourceLocator->locateIdentifier($this->classReflector, $identifier);
        \assert($functionInfo instanceof \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionFunction || $functionInfo === null);
        if ($functionInfo === null) {
            throw \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
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
        $allFunctions = $this->sourceLocator->locateIdentifiersByType($this, new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_FUNCTION));
        return $allFunctions;
    }
}
