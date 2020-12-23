<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Command\ErrorFormatter;

use _PhpScoper0a2ac50786fa\PHPStan\Command\AnalysisResult;
use _PhpScoper0a2ac50786fa\PHPStan\Command\Output;
interface ErrorFormatter
{
    /**
     * Formats the errors and outputs them to the console.
     *
     * @param \PHPStan\Command\AnalysisResult $analysisResult
     * @param \PHPStan\Command\Output $output
     * @return int Error code.
     */
    public function formatErrors(\_PhpScoper0a2ac50786fa\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScoper0a2ac50786fa\PHPStan\Command\Output $output) : int;
}
