<?php

declare (strict_types=1);
namespace PHPStan\Command\ErrorFormatter;

use _PhpScoper88fe6e0ad041\Nette\DI\Helpers;
use _PhpScoper88fe6e0ad041\Nette\Neon\Neon;
use PHPStan\Command\AnalysisResult;
use PHPStan\Command\Output;
use PHPStan\File\RelativePathHelper;
use function preg_quote;
class BaselineNeonErrorFormatter implements \PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    /**
     * @var \PHPStan\File\RelativePathHelper
     */
    private $relativePathHelper;
    public function __construct(\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->relativePathHelper = $relativePathHelper;
    }
    public function formatErrors(\PHPStan\Command\AnalysisResult $analysisResult, \PHPStan\Command\Output $output) : int
    {
        if (!$analysisResult->hasErrors()) {
            $output->writeRaw(\_PhpScoper88fe6e0ad041\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => []]], \_PhpScoper88fe6e0ad041\Nette\Neon\Neon::BLOCK));
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
                $errorsToOutput[] = ['message' => \_PhpScoper88fe6e0ad041\Nette\DI\Helpers::escape('#^' . \preg_quote($message, '#') . '$#'), 'count' => $count, 'path' => \_PhpScoper88fe6e0ad041\Nette\DI\Helpers::escape($this->relativePathHelper->getRelativePath($file))];
            }
        }
        $output->writeRaw(\_PhpScoper88fe6e0ad041\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => $errorsToOutput]], \_PhpScoper88fe6e0ad041\Nette\Neon\Neon::BLOCK));
        return 1;
    }
}