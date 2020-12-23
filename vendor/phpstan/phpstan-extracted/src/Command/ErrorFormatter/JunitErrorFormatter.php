<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Command\ErrorFormatter;

use _PhpScoper0a2ac50786fa\PHPStan\Command\AnalysisResult;
use _PhpScoper0a2ac50786fa\PHPStan\Command\Output;
use _PhpScoper0a2ac50786fa\PHPStan\File\RelativePathHelper;
use function sprintf;
class JunitErrorFormatter implements \_PhpScoper0a2ac50786fa\PHPStan\Command\ErrorFormatter\ErrorFormatter
{
    /** @var \PHPStan\File\RelativePathHelper */
    private $relativePathHelper;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->relativePathHelper = $relativePathHelper;
    }
    public function formatErrors(\_PhpScoper0a2ac50786fa\PHPStan\Command\AnalysisResult $analysisResult, \_PhpScoper0a2ac50786fa\PHPStan\Command\Output $output) : int
    {
        $result = '<?xml version="1.0" encoding="UTF-8"?>';
        $result .= \sprintf('<testsuite failures="%d" name="phpstan" tests="%d" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="https://raw.githubusercontent.com/junit-team/junit5/r5.5.1/platform-tests/src/test/resources/jenkins-junit.xsd">', $analysisResult->getTotalErrorsCount(), $analysisResult->getTotalErrorsCount());
        foreach ($analysisResult->getFileSpecificErrors() as $fileSpecificError) {
            $fileName = $this->relativePathHelper->getRelativePath($fileSpecificError->getFile());
            $result .= $this->createTestCase(\sprintf('%s:%s', $fileName, (string) $fileSpecificError->getLine()), 'ERROR', $this->escape($fileSpecificError->getMessage()));
        }
        foreach ($analysisResult->getNotFileSpecificErrors() as $notFileSpecificError) {
            $result .= $this->createTestCase('General error', 'ERROR', $this->escape($notFileSpecificError));
        }
        foreach ($analysisResult->getWarnings() as $warning) {
            $result .= $this->createTestCase('Warning', 'WARNING', $this->escape($warning));
        }
        if (!$analysisResult->hasErrors()) {
            $result .= $this->createTestCase('phpstan', '');
        }
        $result .= '</testsuite>';
        $output->writeRaw($result);
        return $analysisResult->hasErrors() ? 1 : 0;
    }
    /**
     * Format a single test case
     *
     * @param string      $reference
     * @param string|null $message
     *
     * @return string
     */
    private function createTestCase(string $reference, string $type, ?string $message = null) : string
    {
        $result = \sprintf('<testcase name="%s">', $this->escape($reference));
        if ($message !== null) {
            $result .= \sprintf('<failure type="%s" message="%s" />', $this->escape($type), $this->escape($message));
        }
        $result .= '</testcase>';
        return $result;
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
}
