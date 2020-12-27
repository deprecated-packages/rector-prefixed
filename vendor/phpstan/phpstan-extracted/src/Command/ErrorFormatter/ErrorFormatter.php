<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Command\ErrorFormatter;

use RectorPrefix20201227\PHPStan\Command\AnalysisResult;
use RectorPrefix20201227\PHPStan\Command\Output;
interface ErrorFormatter
{
    /**
     * Formats the errors and outputs them to the console.
     *
     * @param \PHPStan\Command\AnalysisResult $analysisResult
     * @param \PHPStan\Command\Output $output
     * @return int Error code.
     */
    public function formatErrors(\RectorPrefix20201227\PHPStan\Command\AnalysisResult $analysisResult, \RectorPrefix20201227\PHPStan\Command\Output $output) : int;
}
