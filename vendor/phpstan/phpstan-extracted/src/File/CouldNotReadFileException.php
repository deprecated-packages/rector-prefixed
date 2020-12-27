<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\File;

class CouldNotReadFileException extends \RectorPrefix20201227\PHPStan\AnalysedCodeException
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
