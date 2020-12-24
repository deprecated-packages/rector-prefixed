<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Command\ErrorFormatter;

use _PhpScopere8e811afab72\PHPStan\Command\AnalysisResult;
use _PhpScopere8e811afab72\PHPStan\Command\Output;
class RawErrorFormatter implements \_PhpScopere8e811afab72\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    public function formatErrors(\_PhpScopere8e811afab72\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScopere8e811afab72\PHPStan\Command\Output $output) : int
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
