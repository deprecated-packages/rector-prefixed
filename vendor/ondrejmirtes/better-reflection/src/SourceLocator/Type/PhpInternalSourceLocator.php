<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type;

use InvalidArgumentException;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located\InternalLocatedSource;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\SourceStubber\StubData;
final class PhpInternalSourceLocator extends \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type\AbstractSourceLocator
{
    /** @var SourceStubber */
    private $stubber;
    public function __construct(\_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator, \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber $stubber)
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
    protected function createLocatedSource(\_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located\LocatedSource
    {
        return $this->getClassSource($identifier) ?? $this->getFunctionSource($identifier) ?? $this->getConstantSource($identifier);
    }
    private function getClassSource(\_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located\InternalLocatedSource
    {
        if (!$identifier->isClass()) {
            return null;
        }
        return $this->createLocatedSourceFromStubData($this->stubber->generateClassStub($identifier->getName()));
    }
    private function getFunctionSource(\_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located\InternalLocatedSource
    {
        if (!$identifier->isFunction()) {
            return null;
        }
        return $this->createLocatedSourceFromStubData($this->stubber->generateFunctionStub($identifier->getName()));
    }
    private function getConstantSource(\_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located\InternalLocatedSource
    {
        if (!$identifier->isConstant()) {
            return null;
        }
        return $this->createLocatedSourceFromStubData($this->stubber->generateConstantStub($identifier->getName()));
    }
    private function createLocatedSourceFromStubData(?\_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\SourceStubber\StubData $stubData) : ?\_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located\InternalLocatedSource
    {
        if ($stubData === null) {
            return null;
        }
        if ($stubData->getExtensionName() === null) {
            // Not internal
            return null;
        }
        return new \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located\InternalLocatedSource($stubData->getStub(), $stubData->getExtensionName(), $stubData->getFileName());
    }
}
