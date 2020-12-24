<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Command\ErrorFormatter;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Command\AnalysisResult;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Command\Output;
interface ErrorFormatter
{
    /**
     * Formats the errors and outputs them to the console.
     *
     * @param \PHPStan\Command\AnalysisResult $analysisResult
     * @param \PHPStan\Command\Output $output
     * @return int Error code.
     */
    public function formatErrors(\_PhpScoper2a4e7ab1ecbc\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScoper2a4e7ab1ecbc\PHPStan\Command\Output $output) : int;
}
