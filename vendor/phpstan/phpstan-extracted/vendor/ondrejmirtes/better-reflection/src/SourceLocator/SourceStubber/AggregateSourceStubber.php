<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber;

use function array_merge;
use function array_reduce;
class AggregateSourceStubber implements \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber
{
    /** @var SourceStubber[] */
    private $sourceStubbers;
    public function __construct(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber $sourceStubber, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber ...$otherSourceStubbers)
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
    public function generateClassStub(string $className) : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        foreach ($this->sourceStubbers as $sourceStubber) {
            $stubData = $sourceStubber->generateClassStub($className);
            if ($stubData !== null) {
                return $stubData;
            }
        }
        return null;
    }
    public function generateFunctionStub(string $functionName) : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        foreach ($this->sourceStubbers as $sourceStubber) {
            $stubData = $sourceStubber->generateFunctionStub($functionName);
            if ($stubData !== null) {
                return $stubData;
            }
        }
        return null;
    }
    public function generateConstantStub(string $constantName) : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        return \array_reduce($this->sourceStubbers, static function (?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData $stubData, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber $sourceStubber) use($constantName) : ?StubData {
            return $stubData ?? $sourceStubber->generateConstantStub($constantName);
        }, null);
    }
}
