<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\File;

class CouldNotReadFileException extends \_PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException
{
    public function __construct(string $fileName)
    {
        parent::__construct(\sprintf('Could not read file: %s', $fileName));
    }
    public function getTip() : ?string
    {
        return null;
    }
}
