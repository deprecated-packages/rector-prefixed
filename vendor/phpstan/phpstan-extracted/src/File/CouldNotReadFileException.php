<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\File;

class CouldNotReadFileException extends \_PhpScoper0a2ac50786fa\PHPStan\AnalysedCodeException
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
