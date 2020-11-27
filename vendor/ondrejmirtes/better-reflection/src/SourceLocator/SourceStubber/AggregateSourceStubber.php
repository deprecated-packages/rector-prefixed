<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber;

use function array_merge;
use function array_reduce;
class AggregateSourceStubber implements \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber
{
    /** @var SourceStubber[] */
    private $sourceStubbers;
    public function __construct(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber $sourceStubber, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber ...$otherSourceStubbers)
    {
        $this->sourceStubbers = \array_merge([$sourceStubber], $otherSourceStubbers);
    }
    public function hasClass(string $className) : bool
    {
        foreach ($this->sourceStubbers as $sourceStubber) {
            if ($sourceStubber->hasClass($className)) {
                return \true;
            }
        }
        return \false;
    }
    public function generateClassStub(string $className) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        foreach ($this->sourceStubbers as $sourceStubber) {
            $stubData = $sourceStubber->generateClassStub($className);
            if ($stubData !== null) {
                return $stubData;
            }
        }
        return null;
    }
    public function generateFunctionStub(string $functionName) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        foreach ($this->sourceStubbers as $sourceStubber) {
            $stubData = $sourceStubber->generateFunctionStub($functionName);
            if ($stubData !== null) {
                return $stubData;
            }
        }
        return null;
    }
    public function generateConstantStub(string $constantName) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        return \array_reduce($this->sourceStubbers, static function (?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber\StubData $stubData, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber $sourceStubber) use($constantName) : ?StubData {
            return $stubData ?? $sourceStubber->generateConstantStub($constantName);
        }, null);
    }
}
