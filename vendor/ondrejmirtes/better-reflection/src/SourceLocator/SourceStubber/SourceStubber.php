<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber;

/**
 * @internal
 */
interface SourceStubber
{
    public function hasClass(string $className) : bool;
    /**
     * Generates stub for given class. Returns null when it cannot generate the stub.
     */
    public function generateClassStub(string $className) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber\StubData;
    /**
     * Generates stub for given function. Returns null when it cannot generate the stub.
     */
    public function generateFunctionStub(string $functionName) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber\StubData;
    /**
     * Generates stub for given constant. Returns null when it cannot generate the stub.
     */
    public function generateConstantStub(string $constantName) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\SourceStubber\StubData;
}
