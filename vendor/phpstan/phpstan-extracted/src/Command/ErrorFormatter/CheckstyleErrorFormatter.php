<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Command\ErrorFormatter;

use RectorPrefix20201227\PHPStan\Command\AnalysisResult;
use RectorPrefix20201227\PHPStan\Command\Output;
use RectorPrefix20201227\PHPStan\File\RelativePathHelper;
class CheckstyleErrorFormatter implements \RectorPrefix20201227\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    /** @var RelativePathHelper */
    private $relativePathHelper;
    public function __construct(\RectorPrefix20201227\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->relativePathHelper = $relativePathHelper;
    }
    public function formatErrors(\RectorPrefix20201227\PHPStan\Command\AnalysisResult $analysisResult, \RectorPrefix20201227\PHPStan\Command\Output $output) : int
    {
        $output->writeRaw('<?xml version="1.0" encoding="UTF-8"?>');
        $output->writeLineFormatted('');
        $output->writeRaw('<checkstyle>');
        $output->writeLineFormatted('');
        foreach ($this->groupByFile($analysisResult) as $relativeFilePath => $errors) {
            $output->writeRaw(\sprintf('<file name="%s">', $this->escape($relativeFilePath)));
            $output->writeLineFormatted('');
            foreach ($errors as $error) {
                $output->writeRaw(\sprintf('  <error line="%d" column="1" severity="error" message="%s" />', $this->escape((string) $error->getLine()), $this->escape((string) $error->getMessage())));
                $output->writeLineFormatted('');
            }
            $output->writeRaw('</file>');
            $output->writeLineFormatted('');
        }
        $notFileSpecificErrors = $analysisResult->getNotFileSpecificErrors();
        if (\count($notFileSpecificErrors) > 0) {
            $output->writeRaw('<file>');
            $output->writeLineFormatted('');
            foreach ($notFileSpecificErrors as $error) {
                $output->writeRaw(\sprintf('  <error severity="error" message="%s" />', $this->escape($error)));
                $output->writeLineFormatted('');
            }
            $output->writeRaw('</file>');
            $output->writeLineFormatted('');
        }
        if ($analysisResult->hasWarnings()) {
            $output->writeRaw('<file>');
            $output->writeLineFormatted('');
            foreach ($analysisResult->getWarnings() as $warning) {
                $output->writeRaw(\sprintf('  <error severity="warning" message="%s" />', $this->escape($warning)));
                $output->writeLineFormatted('');
            }
            $output->writeRaw('</file>');
            $output->writeLineFormatted('');
        }
        $output->writeRaw('</checkstyle>');
        $output->writeLineFormatted('');
        return $analysisResult->hasErrors() ? 1 : 0;
    }
    /**
     * Escapes values for using in XML
     *
     * @param string $string
     * @return string
     */
    protected function escape(string $string) : string
    {
        return \htmlspecialchars($string, \ENT_XML1 | \ENT_COMPAT, 'UTF-8');
    }
    /**
     * Group errors by file
     *
     * @param AnalysisResult $analysisResult
     * @return array<string, array> Array that have as key the relative path of file
     *                              and as value an array with occurred errors.
     */
    private function groupByFile(\RectorPrefix20201227\PHPStan\Command\AnalysisResult $analysisResult) : array
    {
        $files = [];
        /** @var \PHPStan\Analyser\Error $fileSpecificError */
        foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
            $absolutePath = $fileSpecificError->getFilePath();
            if ($fileSpecificError->getTraitFilePath() !== null) {
                $absolutePath = $fileSpecificError->getTraitFilePath();
            }
            $relativeFilePath = $this->relativePathHelper->getRelativePath($absolutePath);
            $files[$relativeFilePath][] = $fileSpecificError;
        }
        return $files;
    }
}
