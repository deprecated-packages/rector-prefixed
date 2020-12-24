<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\File;

class CouldNotReadFileException extends \_PhpScoperb75b35f52b74\PHPStan\AnalysedCodeException
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
