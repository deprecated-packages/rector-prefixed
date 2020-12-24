<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Command\ErrorFormatter;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Helpers;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Neon\Neon;
use _PhpScoperb75b35f52b74\PHPStan\Command\AnalysisResult;
use _PhpScoperb75b35f52b74\PHPStan\Command\Output;
use _PhpScoperb75b35f52b74\PHPStan\File\RelativePathHelper;
use function preg_quote;
class BaselineNeonErrorFormatter implements \_PhpScoperb75b35f52b74\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    /** @var \PHPStan\File\RelativePathHelper */
    private $relativePathHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->relativePathHelper = $relativePathHelper;
    }
    public function formatErrors(\_PhpScoperb75b35f52b74\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScoperb75b35f52b74\PHPStan\Command\Output $output) : int
    {
        if (!$analysisResult->hasErrors()) {
            $output->writeRaw(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => []]], \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::BLOCK));
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
                $errorsToOutput[] = ['message' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::escape('#^' . \preg_quote($message, '#') . '$#'), 'count' => $count, 'path' => \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::escape($this->relativePathHelper->getRelativePath($file))];
            }
        }
        $output->writeRaw(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => $errorsToOutput]], \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::BLOCK));
        return 1;
    }
}
