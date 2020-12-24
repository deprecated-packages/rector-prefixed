<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Analyser\ResultCache;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\AnalyserResult;
class ResultCacheProcessResult
{
    /** @var AnalyserResult */
    private $analyserResult;
    /** @var bool */
    private $saved;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Analyser\AnalyserResult $analyserResult, bool $saved)
    {
        $this->analyserResult = $analyserResult;
        $this->saved = $saved;
    }
    public function getAnalyserResult() : \_PhpScoperb75b35f52b74\PHPStan\Analyser\AnalyserResult
    {
        return $this->analyserResult;
    }
    public function isSaved() : bool
    {
        return $this->saved;
    }
}
