<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use function array_key_exists;
use function assert;
use function strtolower;
class ClassReflector implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var (ReflectionClass|null)[] */
    private $cachedReflections = [];
    public function __construct(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator)
    {
        $this->sourceLocator = $sourceLocator;
    }
    /**
     * Create a ReflectionClass for the specified $className.
     *
     * @return ReflectionClass
     *
     * @throws IdentifierNotFound
     */
    public function reflect(string $className) : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        $lowerClassName = \strtolower($className);
        if (\array_key_exists($lowerClassName, $this->cachedReflections)) {
            $classInfo = $this->cachedReflections[$lowerClassName];
        } else {
            $identifier = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier($className, new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CLASS));
            $classInfo = $this->sourceLocator->locateIdentifier($this, $identifier);
            \assert($classInfo instanceof \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass || $classInfo === null);
            $this->cachedReflections[$lowerClassName] = $classInfo;
        }
        if ($classInfo === null) {
            if (!isset($identifier)) {
                $identifier = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier($className, new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CLASS));
            }
            throw \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
        }
        return $classInfo;
    }
    /**
     * Get all the classes available in the scope specified by the SourceLocator.
     *
     * @return ReflectionClass[]
     */
    public function getAllClasses() : array
    {
        /** @var ReflectionClass[] $allClasses */
        $allClasses = $this->sourceLocator->locateIdentifiersByType($this, new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CLASS));
        return $allClasses;
    }
}
