<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Command\ErrorFormatter;

use _PhpScopere8e811afab72\PHPStan\Command\AnalysisResult;
use _PhpScopere8e811afab72\PHPStan\Command\Output;
interface ErrorFormatter
{
    /**
     * Formats the errors and outputs them to the console.
     *
     * @param \PHPStan\Command\AnalysisResult $analysisResult
     * @param \PHPStan\Command\Output $output
     * @return int Error code.
     */
    public function formatErrors(\_PhpScopere8e811afab72\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScopere8e811afab72\PHPStan\Command\Output $output) : int;
}
