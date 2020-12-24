<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Command\ErrorFormatter;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\DI\Helpers;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Neon\Neon;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Command\AnalysisResult;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Command\Output;
use _PhpScoper2a4e7ab1ecbc\PHPStan\File\RelativePathHelper;
use function preg_quote;
class BaselineNeonErrorFormatter implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    /** @var \PHPStan\File\RelativePathHelper */
    private $relativePathHelper;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->relativePathHelper = $relativePathHelper;
    }
    public function formatErrors(\_PhpScoper2a4e7ab1ecbc\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScoper2a4e7ab1ecbc\PHPStan\Command\Output $output) : int
    {
        if (!$analysisResult->hasErrors()) {
            $output->writeRaw(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => []]], \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::BLOCK));
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
                $errorsToOutput[] = ['message' => \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::escape('#^' . \preg_quote($message, '#') . '$#'), 'count' => $count, 'path' => \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\DI\Helpers::escape($this->relativePathHelper->getRelativePath($file))];
            }
        }
        $output->writeRaw(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => $errorsToOutput]], \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Neon\Neon::BLOCK));
        return 1;
    }
}
