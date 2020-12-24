<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type;

use InvalidArgumentException;
use ReflectionClass;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\EvaledLocatedSource;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use function class_exists;
use function file_exists;
use function interface_exists;
use function trait_exists;
final class EvaledCodeSourceLocator extends \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AbstractSourceLocator
{
    /** @var SourceStubber */
    private $stubber;
    public function __construct(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber $stubber)
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
    protected function createLocatedSource(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource
    {
        $classReflection = $this->getInternalReflectionClass($identifier);
        if ($classReflection === null) {
            return null;
        }
        $stubData = $this->stubber->generateClassStub($classReflection->getName());
        if ($stubData === null) {
            return null;
        }
        return new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\EvaledLocatedSource($stubData->getStub());
    }
    private function getInternalReflectionClass(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\ReflectionClass
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
