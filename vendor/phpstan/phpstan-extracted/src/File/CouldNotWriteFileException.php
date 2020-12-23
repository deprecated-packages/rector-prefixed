<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\File;

class CouldNotWriteFileException extends \_PhpScoper0a2ac50786fa\PHPStan\AnalysedCodeException
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
