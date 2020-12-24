<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Command\ErrorFormatter;

use _PhpScoper0a6b37af0871\PHPStan\Command\AnalysisResult;
use _PhpScoper0a6b37af0871\PHPStan\Command\Output;
interface ErrorFormatter
{
    /**
     * Formats the errors and outputs them to the console.
     *
     * @param \PHPStan\Command\AnalysisResult $analysisResult
     * @param \PHPStan\Command\Output $output
     * @return int Error code.
     */
    public function formatErrors(\_PhpScoper0a6b37af0871\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScoper0a6b37af0871\PHPStan\Command\Output $output) : int;
}
