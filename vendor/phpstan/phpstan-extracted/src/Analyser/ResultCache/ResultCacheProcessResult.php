<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser\ResultCache;

use RectorPrefix20201227\PHPStan\Analyser\AnalyserResult;
class ResultCacheProcessResult
{
    /** @var AnalyserResult */
    private $analyserResult;
    /** @var bool */
    private $saved;
    public function __construct(\RectorPrefix20201227\PHPStan\Analyser\AnalyserResult $analyserResult, bool $saved)
    {
        $this->analyserResult = $analyserResult;
        $this->saved = $saved;
    }
    public function getAnalyserResult() : \RectorPrefix20201227\PHPStan\Analyser\AnalyserResult
    {
        return $this->analyserResult;
    }
    public function isSaved() : bool
    {
        return $this->saved;
    }
}
