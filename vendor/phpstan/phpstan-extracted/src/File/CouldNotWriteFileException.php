<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\File;

class CouldNotWriteFileException extends \RectorPrefix20201227\PHPStan\AnalysedCodeException
{
    public function __construct(string $fileName, string $error)
    {
        parent::__construct(\sprintf('Could not write file: %s (%s)', $fileName, $error));
    }
    public function getTip() : ?string
    {
        return null;
    }
}
