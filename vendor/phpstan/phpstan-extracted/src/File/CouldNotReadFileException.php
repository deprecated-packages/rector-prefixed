<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\File;

class CouldNotReadFileException extends \_PhpScopere8e811afab72\PHPStan\AnalysedCodeException
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
