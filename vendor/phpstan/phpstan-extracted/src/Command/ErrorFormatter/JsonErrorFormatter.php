<?php

declare (strict_types=1);
namespace PHPStan\Command\ErrorFormatter;

use _HumbugBox221ad6f1b81f\Nette\Utils\Json;
use PHPStan\Command\AnalysisResult;
use PHPStan\Command\Output;
class JsonErrorFormatter implements \PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    /** @var bool */
    private $pretty;
    public function __construct(bool $pretty)
    {
        $this->pretty = $pretty;
    }
    public function formatErrors(\PHPStan\Command\AnalysisResult $analysisResult, \PHPStan\Command\Output $output) : int
    {
        $errorsArray = ['totals' => ['errors' => \count($analysisResult->getNotFileSpecificErrors()), 'file_errors' => \count($analysisResult->getFileSpecificErrors())], 'files' => [], 'errors' => []];
        foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
            $file = $fileSpecificError->getFile();
            if (!\array_key_exists($file, $errorsArray['files'])) {
                $errorsArray['files'][$file] = ['errors' => 0, 'messages' => []];
            }
            $errorsArray['files'][$file]['errors']++;
            $errorsArray['files'][$file]['messages'][] = ['message' => $fileSpecificError->getMessage(), 'line' => $fileSpecificError->getLine(), 'ignorable' => $fileSpecificError->canBeIgnored()];
        }
        foreach ($analysisResult->getNotFileSpecificErrors() as $notFileSpecificError) {
            $errorsArray['errors'][] = $notFileSpecificError;
        }
        $json = \_HumbugBox221ad6f1b81f\Nette\Utils\Json::encode($errorsArray, $this->pretty ? \_HumbugBox221ad6f1b81f\Nette\Utils\Json::PRETTY : 0);
        $output->writeRaw($json);
        return $analysisResult->hasErrors() ? 1 : 0;
    }
}
