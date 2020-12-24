<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\File;

class CouldNotWriteFileException extends \_PhpScopere8e811afab72\PHPStan\AnalysedCodeException
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
