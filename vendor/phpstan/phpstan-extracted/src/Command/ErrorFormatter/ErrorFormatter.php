<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Command\ErrorFormatter;

use _PhpScoperb75b35f52b74\PHPStan\Command\AnalysisResult;
use _PhpScoperb75b35f52b74\PHPStan\Command\Output;
interface ErrorFormatter
{
    /**
     * Formats the errors and outputs them to the console.
     *
     * @param \PHPStan\Command\AnalysisResult $analysisResult
     * @param \PHPStan\Command\Output $output
     * @return int Error code.
     */
    public function formatErrors(\_PhpScoperb75b35f52b74\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScoperb75b35f52b74\PHPStan\Command\Output $output) : int;
}
