<?php

declare (strict_types=1);
namespace PHPStan\Analyser\ResultCache;

use PHPStan\Analyser\AnalyserResult;
class ResultCacheProcessResult
{
    /** @var AnalyserResult */
    private $analyserResult;
    /** @var bool */
    private $saved;
    public function __construct(\PHPStan\Analyser\AnalyserResult $analyserResult, bool $saved)
    {
        $this->analyserResult = $analyserResult;
        $this->saved = $saved;
    }
    public function getAnalyserResult() : \PHPStan\Analyser\AnalyserResult
    {
        return $this->analyserResult;
    }
    public function isSaved() : bool
    {
        return $this->saved;
    }
}
