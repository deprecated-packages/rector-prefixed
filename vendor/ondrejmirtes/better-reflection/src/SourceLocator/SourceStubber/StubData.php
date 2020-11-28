<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\SourceStubber;

/**
 * @internal
 */
class StubData
{
    /** @var string */
    private $stub;
    /** @var string|null */
    private $extensionName;
    /** @var string|null */
    private $fileName;
    public function __construct(string $stub, ?string $extensionName, ?string $fileName = null)
    {
        $this->stub = $stub;
        $this->extensionName = $extensionName;
        $this->fileName = $fileName;
    }
    public function getStub() : string
    {
        return $this->stub;
    }
    public function getExtensionName() : ?string
    {
        return $this->extensionName;
    }
    public function getFileName() : ?string
    {
        return $this->fileName;
    }
}
