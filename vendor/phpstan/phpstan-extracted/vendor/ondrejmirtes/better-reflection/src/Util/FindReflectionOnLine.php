<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util;

use InvalidArgumentException;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SingleFileSourceLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use function array_merge;
use function method_exists;
final class FindReflectionOnLine
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var Locator */
    private $astLocator;
    public function __construct(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        $this->sourceLocator = $sourceLocator;
        $this->astLocator = $astLocator;
    }
    /**
     * Find a reflection on the specified line number.
     *
     * Returns null if no reflections found on the line.
     *
     * @return ReflectionMethod|ReflectionClass|ReflectionFunction|ReflectionConstant|Reflection|null
     *
     * @throws InvalidFileLocation
     * @throws ParseToAstFailure
     * @throws InvalidArgumentException
     */
    public function __invoke(string $filename, int $lineNumber)
    {
        $reflections = $this->computeReflections($filename);
        foreach ($reflections as $reflection) {
            if ($reflection instanceof \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass && $this->containsLine($reflection, $lineNumber)) {
                foreach ($reflection->getMethods() as $method) {
                    if ($this->containsLine($method, $lineNumber)) {
                        return $method;
                    }
                }
                return $reflection;
            }
            if ($reflection instanceof \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction && $this->containsLine($reflection, $lineNumber)) {
                return $reflection;
            }
            if ($reflection instanceof \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant && $this->containsLine($reflection, $lineNumber)) {
                return $reflection;
            }
        }
        return null;
    }
    /**
     * Find all class and function reflections in the specified file
     *
     * @return Reflection[]
     *
     * @throws ParseToAstFailure
     * @throws InvalidFileLocation
     */
    private function computeReflections(string $filename) : array
    {
        $singleFileSourceLocator = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SingleFileSourceLocator($filename, $this->astLocator);
        $reflector = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector(new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator([$singleFileSourceLocator, $this->sourceLocator]));
        return \array_merge($singleFileSourceLocator->locateIdentifiersByType($reflector, new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CLASS)), $singleFileSourceLocator->locateIdentifiersByType($reflector, new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_FUNCTION)), $singleFileSourceLocator->locateIdentifiersByType($reflector, new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CONSTANT)));
    }
    /**
     * Check to see if the line is within the boundaries of the reflection specified.
     *
     * @param ReflectionMethod|ReflectionClass|ReflectionFunction|Reflection $reflection
     *
     * @throws InvalidArgumentException
     */
    private function containsLine($reflection, int $lineNumber) : bool
    {
        if (!\method_exists($reflection, 'getStartLine')) {
            throw new \InvalidArgumentException('Reflection does not have getStartLine method');
        }
        if (!\method_exists($reflection, 'getEndLine')) {
            throw new \InvalidArgumentException('Reflection does not have getEndLine method');
        }
        return $lineNumber >= $reflection->getStartLine() && $lineNumber <= $reflection->getEndLine();
    }
}
