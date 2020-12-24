<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\File;

class SimpleRelativePathHelper implements \_PhpScoper2a4e7ab1ecbc\PHPStan\File\RelativePathHelper
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
