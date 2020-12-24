<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\File;

class CouldNotWriteFileException extends \_PhpScoperb75b35f52b74\PHPStan\AnalysedCodeException
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
