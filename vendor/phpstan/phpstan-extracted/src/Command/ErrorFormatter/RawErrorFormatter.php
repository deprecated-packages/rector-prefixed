<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Command\ErrorFormatter;

use _PhpScoper0a2ac50786fa\PHPStan\Command\AnalysisResult;
use _PhpScoper0a2ac50786fa\PHPStan\Command\Output;
class RawErrorFormatter implements \_PhpScoper0a2ac50786fa\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    public function formatErrors(\_PhpScoper0a2ac50786fa\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScoper0a2ac50786fa\PHPStan\Command\Output $output) : int
    {
        foreach ($analysisResult->getNotFileSpecificErrors() as $notFileSpecificError) {
            $output->writeRaw(\sprintf('?:?:%s', $notFileSpecificError));
            $output->writeLineFormatted('');
        }
        foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
            $output->writeRaw(\sprintf('%s:%d:%s', $fileSpecificError->getFile(), $fileSpecificError->getLine() ?? '?', $fileSpecificError->getMessage()));
            $output->writeLineFormatted('');
        }
        foreach ($analysisResult->getWarnings() as $warning) {
            $output->writeRaw(\sprintf('?:?:%s', $warning));
            $output->writeLineFormatted('');
        }
        return $analysisResult->hasErrors() ? 1 : 0;
    }
}
