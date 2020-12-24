<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber;

/**
 * @internal
 */
interface SourceStubber
{
    public function hasClass(string $className) : bool;
    /**
     * Generates stub for given class. Returns null when it cannot generate the stub.
     */
    public function generateClassStub(string $className) : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData;
    /**
     * Generates stub for given function. Returns null when it cannot generate the stub.
     */
    public function generateFunctionStub(string $functionName) : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData;
    /**
     * Generates stub for given constant. Returns null when it cannot generate the stub.
     */
    public function generateConstantStub(string $constantName) : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData;
}
