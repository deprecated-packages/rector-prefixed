<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\File;

class SimpleRelativePathHelper implements \_PhpScoper0a6b37af0871\PHPStan\File\RelativePathHelper
{
    /** @var string */
    private $currentWorkingDirectory;
    public function __construct(string $currentWorkingDirectory)
    {
        $this->currentWorkingDirectory = $currentWorkingDirectory;
    }
    public function getRelativePath(string $filename) : string
    {
        if ($this->currentWorkingDirectory !== '' && \strpos($filename, $this->currentWorkingDirectory) === 0) {
            return \substr($filename, \strlen($this->currentWorkingDirectory) + 1);
        }
        return $filename;
    }
}
