<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\File;

class CouldNotWriteFileException extends \_PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException
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
