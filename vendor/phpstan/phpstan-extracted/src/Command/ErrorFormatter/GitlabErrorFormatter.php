<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Command\ErrorFormatter;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Json;
use RectorPrefix20201227\PHPStan\Command\AnalysisResult;
use RectorPrefix20201227\PHPStan\Command\Output;
use RectorPrefix20201227\PHPStan\File\RelativePathHelper;
/**
 * @see https://docs.gitlab.com/ee/user/project/merge_requests/code_quality.html#implementing-a-custom-tool
 */
class GitlabErrorFormatter implements \RectorPrefix20201227\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    /** @var RelativePathHelper */
    private $relativePathHelper;
    public function __construct(\RectorPrefix20201227\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->relativePathHelper = $relativePathHelper;
    }
    public function formatErrors(\RectorPrefix20201227\PHPStan\Command\AnalysisResult $analysisResult, \RectorPrefix20201227\PHPStan\Command\Output $output) : int
    {
        $errorsArray = [];
        foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
            $error = ['description' => $fileSpecificError->getMessage(), 'fingerprint' => \hash('sha256', \implode([$fileSpecificError->getFile(), $fileSpecificError->getLine(), $fileSpecificError->getMessage()])), 'location' => ['path' => $this->relativePathHelper->getRelativePath($fileSpecificError->getFile()), 'lines' => ['begin' => $fileSpecificError->getLine()]]];
            if (!$fileSpecificError->canBeIgnored()) {
                $error['severity'] = 'blocker';
            }
            $errorsArray[] = $error;
        }
        foreach ($analysisResult->getNotFileSpecificErrors() as $notFileSpecificError) {
            $errorsArray[] = ['description' => $notFileSpecificError, 'fingerprint' => \hash('sha256', $notFileSpecificError), 'location' => ['path' => '', 'lines' => ['begin' => 0]]];
        }
        $json = \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Json::encode($errorsArray, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Json::PRETTY);
        $output->writeRaw($json);
        return $analysisResult->hasErrors() ? 1 : 0;
    }
}
