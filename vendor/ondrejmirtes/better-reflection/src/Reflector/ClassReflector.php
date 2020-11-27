<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector;

use _PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use function array_key_exists;
use function assert;
use function strtolower;
class ClassReflector implements \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Reflector
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var (ReflectionClass|null)[] */
    private $cachedReflections = [];
    public function __construct(\_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator)
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
    public function reflect(string $className) : \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Reflection
    {
        $lowerClassName = \strtolower($className);
        if (\array_key_exists($lowerClassName, $this->cachedReflections)) {
            $classInfo = $this->cachedReflections[$lowerClassName];
        } else {
            $identifier = new \_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier($className, new \_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CLASS));
            $classInfo = $this->sourceLocator->locateIdentifier($this, $identifier);
            \assert($classInfo instanceof \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass || $classInfo === null);
            $this->cachedReflections[$lowerClassName] = $classInfo;
        }
        if ($classInfo === null) {
            if (!isset($identifier)) {
                $identifier = new \_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier($className, new \_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CLASS));
            }
            throw \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
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
        $allClasses = $this->sourceLocator->locateIdentifiersByType($this, new \_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CLASS));
        return $allClasses;
    }
}
