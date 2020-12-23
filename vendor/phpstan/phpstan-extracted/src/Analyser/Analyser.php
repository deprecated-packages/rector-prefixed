<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Analyser;

use _PhpScoper0a2ac50786fa\PHPStan\Rules\Registry;
class Analyser
{
    /** @var \PHPStan\Analyser\FileAnalyser */
    private $fileAnalyser;
    /** @var Registry */
    private $registry;
    /** @var \PHPStan\Analyser\NodeScopeResolver */
    private $nodeScopeResolver;
    /** @var int */
    private $internalErrorsCountLimit;
    /** @var \PHPStan\Analyser\Error[] */
    private $collectedErrors = [];
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\FileAnalyser $fileAnalyser, \_PhpScoper0a2ac50786fa\PHPStan\Rules\Registry $registry, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver, int $internalErrorsCountLimit)
    {
        $this->fileAnalyser = $fileAnalyser;
        $this->registry = $registry;
        $this->nodeScopeResolver = $nodeScopeResolver;
        $this->internalErrorsCountLimit = $internalErrorsCountLimit;
    }
    /**
     * @param string[] $files
     * @param \Closure(string $file): void|null $preFileCallback
     * @param \Closure(int): void|null $postFileCallback
     * @param bool $debug
     * @param string[]|null $allAnalysedFiles
     * @return AnalyserResult
     */
    public function analyse(array $files, ?\Closure $preFileCallback = null, ?\Closure $postFileCallback = null, bool $debug = \false, ?array $allAnalysedFiles = null) : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\AnalyserResult
    {
        if ($allAnalysedFiles === null) {
            $allAnalysedFiles = $files;
        }
        $this->nodeScopeResolver->setAnalysedFiles($allAnalysedFiles);
        $allAnalysedFiles = \array_fill_keys($allAnalysedFiles, \true);
        $this->collectErrors($files);
        $errors = [];
        $internalErrorsCount = 0;
        $reachedInternalErrorsCountLimit = \false;
        $dependencies = [];
        $exportedNodes = [];
        foreach ($files as $file) {
            if ($preFileCallback !== null) {
                $preFileCallback($file);
            }
            try {
                $fileAnalyserResult = $this->fileAnalyser->analyseFile($file, $allAnalysedFiles, $this->registry, null);
                $errors = \array_merge($errors, $fileAnalyserResult->getErrors());
                $dependencies[$file] = $fileAnalyserResult->getDependencies();
                $fileExportedNodes = $fileAnalyserResult->getExportedNodes();
                if (\count($fileExportedNodes) > 0) {
                    $exportedNodes[$file] = $fileExportedNodes;
                }
            } catch (\Throwable $t) {
                if ($debug) {
                    throw $t;
                }
                $internalErrorsCount++;
                $internalErrorMessage = \sprintf('Internal error: %s', $t->getMessage());
                $internalErrorMessage .= \sprintf('%sRun PHPStan with --debug option and post the stack trace to:%s%s', "\n", "\n", 'https://github.com/phpstan/phpstan/issues/new');
                $errors[] = new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Error($internalErrorMessage, $file, null, $t);
                if ($internalErrorsCount >= $this->internalErrorsCountLimit) {
                    $reachedInternalErrorsCountLimit = \true;
                    break;
                }
            }
            if ($postFileCallback === null) {
                continue;
            }
            $postFileCallback(1);
        }
        $this->restoreCollectErrorsHandler();
        $errors = \array_merge($errors, $this->collectedErrors);
        return new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\AnalyserResult($errors, [], $internalErrorsCount === 0 ? $dependencies : null, $exportedNodes, $reachedInternalErrorsCountLimit);
    }
    /**
     * @param string[] $analysedFiles
     */
    private function collectErrors(array $analysedFiles) : void
    {
        $this->collectedErrors = [];
        \set_error_handler(function (int $errno, string $errstr, string $errfile, int $errline) use($analysedFiles) : bool {
            if (\error_reporting() === 0) {
                // silence @ operator
                return \true;
            }
            if (!\in_array($errfile, $analysedFiles, \true)) {
                return \true;
            }
            $this->collectedErrors[] = new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Error($errstr, $errfile, $errline, \true);
            return \true;
        });
    }
    private function restoreCollectErrorsHandler() : void
    {
        \restore_error_handler();
    }
}
