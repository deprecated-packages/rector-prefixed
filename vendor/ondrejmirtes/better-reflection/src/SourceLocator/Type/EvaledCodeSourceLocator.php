<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type;

use InvalidArgumentException;
use ReflectionClass;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\EvaledLocatedSource;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use function class_exists;
use function file_exists;
use function interface_exists;
use function trait_exists;
final class EvaledCodeSourceLocator extends \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\AbstractSourceLocator
{
    /** @var SourceStubber */
    private $stubber;
    public function __construct(\_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator, \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber $stubber)
    {
        parent::__construct($astLocator);
        $this->stubber = $stubber;
    }
    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     * @throws InvalidFileLocation
     */
    protected function createLocatedSource(\_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\LocatedSource
    {
        $classReflection = $this->getInternalReflectionClass($identifier);
        if ($classReflection === null) {
            return null;
        }
        $stubData = $this->stubber->generateClassStub($classReflection->getName());
        if ($stubData === null) {
            return null;
        }
        return new \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\EvaledLocatedSource($stubData->getStub());
    }
    private function getInternalReflectionClass(\_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\ReflectionClass
    {
        if (!$identifier->isClass()) {
            return null;
        }
        $name = $identifier->getName();
        if (!(\class_exists($name, \false) || \interface_exists($name, \false) || \trait_exists($name, \false))) {
            return null;
            // not an available internal class
        }
        $reflection = new \ReflectionClass($name);
        $sourceFile = $reflection->getFileName();
        return $sourceFile && \file_exists($sourceFile) ? null : $reflection;
    }
}
