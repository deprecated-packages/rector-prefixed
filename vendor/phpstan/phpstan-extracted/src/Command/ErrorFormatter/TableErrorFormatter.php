<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Command\ErrorFormatter;

use _PhpScoperb75b35f52b74\PHPStan\Command\AnalyseCommand;
use _PhpScoperb75b35f52b74\PHPStan\Command\AnalysisResult;
use _PhpScoperb75b35f52b74\PHPStan\Command\Output;
use _PhpScoperb75b35f52b74\PHPStan\File\RelativePathHelper;
class TableErrorFormatter implements \_PhpScoperb75b35f52b74\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    /** @var RelativePathHelper */
    private $relativePathHelper;
    /** @var bool */
    private $showTipsOfTheDay;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\File\RelativePathHelper $relativePathHelper, bool $showTipsOfTheDay)
    {
        $this->relativePathHelper = $relativePathHelper;
        $this->showTipsOfTheDay = $showTipsOfTheDay;
    }
    public function formatErrors(\_PhpScoperb75b35f52b74\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScoperb75b35f52b74\PHPStan\Command\Output $output) : int
    {
        $projectConfigFile = 'phpstan.neon';
        if ($analysisResult->getProjectConfigFile() !== null) {
            $projectConfigFile = $this->relativePathHelper->getRelativePath($analysisResult->getProjectConfigFile());
        }
        $style = $output->getStyle();
        if (!$analysisResult->hasErrors() && !$analysisResult->hasWarnings()) {
            $style->success('No errors');
            if ($this->showTipsOfTheDay) {
                if ($analysisResult->isDefaultLevelUsed()) {
                    $output->writeLineFormatted('💡 Tip of the Day:');
                    $output->writeLineFormatted(\sprintf("PHPStan is performing only the most basic checks.\nYou can pass a higher rule level through the <fg=cyan>--%s</> option\n(the default and current level is %d) to analyse code more thoroughly.", \_PhpScoperb75b35f52b74\PHPStan\Command\AnalyseCommand::OPTION_LEVEL, \_PhpScoperb75b35f52b74\PHPStan\Command\AnalyseCommand::DEFAULT_LEVEL));
                    $output->writeLineFormatted('');
                }
            }
            return 0;
        }
        /** @var array<string, \PHPStan\Analyser\Error[]> $fileErrors */
        $fileErrors = [];
        foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
            if (!isset($fileErrors[$fileSpecificError->getFile()])) {
                $fileErrors[$fileSpecificError->getFile()] = [];
            }
            $fileErrors[$fileSpecificError->getFile()][] = $fileSpecificError;
        }
        foreach ($fileErrors as $file => $errors) {
            $rows = [];
            foreach ($errors as $error) {
                $message = $error->getMessage();
                if ($error->getTip() !== null) {
                    $tip = $error->getTip();
                    $tip = \str_replace('%configurationFile%', $projectConfigFile, $tip);
                    $message .= "\n💡 " . $tip;
                }
                $rows[] = [(string) $error->getLine(), $message];
            }
            $relativeFilePath = $this->relativePathHelper->getRelativePath($file);
            $style->table(['Line', $relativeFilePath], $rows);
        }
        if (\count($analysisResult->getNotFileSpecificErrors()) > 0) {
            $style->table(['', 'Error'], \array_map(static function (string $error) : array {
                return ['', $error];
            }, $analysisResult->getNotFileSpecificErrors()));
        }
        $warningsCount = \count($analysisResult->getWarnings());
        if ($warningsCount > 0) {
            $style->table(['', 'Warning'], \array_map(static function (string $warning) : array {
                return ['', $warning];
            }, $analysisResult->getWarnings()));
        }
        $finalMessage = \sprintf($analysisResult->getTotalErrorsCount() === 1 ? 'Found %d error' : 'Found %d errors', $analysisResult->getTotalErrorsCount());
        if ($warningsCount > 0) {
            $finalMessage .= \sprintf($warningsCount === 1 ? ' and %d warning' : ' and %d warnings', $warningsCount);
        }
        if ($analysisResult->getTotalErrorsCount() > 0) {
            $style->error($finalMessage);
        } else {
            $style->warning($finalMessage);
        }
        return $analysisResult->getTotalErrorsCount() > 0 ? 1 : 0;
    }
}
