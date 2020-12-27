<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Command\ErrorFormatter;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\DI\Helpers;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Neon\Neon;
use RectorPrefix20201227\PHPStan\Command\AnalysisResult;
use RectorPrefix20201227\PHPStan\Command\Output;
use RectorPrefix20201227\PHPStan\File\RelativePathHelper;
use function preg_quote;
class BaselineNeonErrorFormatter implements \RectorPrefix20201227\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    /** @var \PHPStan\File\RelativePathHelper */
    private $relativePathHelper;
    public function __construct(\RectorPrefix20201227\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->relativePathHelper = $relativePathHelper;
    }
    public function formatErrors(\RectorPrefix20201227\PHPStan\Command\AnalysisResult $analysisResult, \RectorPrefix20201227\PHPStan\Command\Output $output) : int
    {
        if (!$analysisResult->hasErrors()) {
            $output->writeRaw(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => []]], \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Neon\Neon::BLOCK));
            return 0;
        }
        $fileErrors = [];
        foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
            if (!$fileSpecificError->canBeIgnored()) {
                continue;
            }
            $fileErrors[$fileSpecificError->getFilePath()][] = $fileSpecificError->getMessage();
        }
        $errorsToOutput = [];
        foreach ($fileErrors as $file => $errorMessages) {
            $fileErrorsCounts = [];
            foreach ($errorMessages as $errorMessage) {
                if (!isset($fileErrorsCounts[$errorMessage])) {
                    $fileErrorsCounts[$errorMessage] = 1;
                    continue;
                }
                $fileErrorsCounts[$errorMessage]++;
            }
            foreach ($fileErrorsCounts as $message => $count) {
                $errorsToOutput[] = ['message' => \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\DI\Helpers::escape('#^' . \preg_quote($message, '#') . '$#'), 'count' => $count, 'path' => \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\DI\Helpers::escape($this->relativePathHelper->getRelativePath($file))];
            }
        }
        $output->writeRaw(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => $errorsToOutput]], \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Neon\Neon::BLOCK));
        return 1;
    }
}
