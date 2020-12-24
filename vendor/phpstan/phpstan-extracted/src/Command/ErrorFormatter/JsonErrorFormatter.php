<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Command\ErrorFormatter;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Json;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Command\AnalysisResult;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Command\Output;
class JsonErrorFormatter implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    /** @var bool */
    private $pretty;
    public function __construct(bool $pretty)
    {
        $this->pretty = $pretty;
    }
    public function formatErrors(\_PhpScoper2a4e7ab1ecbc\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScoper2a4e7ab1ecbc\PHPStan\Command\Output $output) : int
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
        $json = \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Json::encode($errorsArray, $this->pretty ? \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Json::PRETTY : 0);
        $output->writeRaw($json);
        return $analysisResult->hasErrors() ? 1 : 0;
    }
}
