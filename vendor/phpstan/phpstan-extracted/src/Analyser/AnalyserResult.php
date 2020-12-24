<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Analyser;

use _PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNode;
class AnalyserResult
{
    /** @var \PHPStan\Analyser\Error[] */
    private $unorderedErrors;
    /** @var \PHPStan\Analyser\Error[] */
    private $errors;
    /** @var string[] */
    private $internalErrors;
    /** @var array<string, array<string>>|null */
    private $dependencies;
    /** @var array<string, array<ExportedNode>> */
    private $exportedNodes;
    /** @var bool */
    private $reachedInternalErrorsCountLimit;
    /**
     * @param \PHPStan\Analyser\Error[] $errors
     * @param string[] $internalErrors
     * @param array<string, array<string>>|null $dependencies
     * @param array<string, array<ExportedNode>> $exportedNodes
     * @param bool $reachedInternalErrorsCountLimit
     */
    public function __construct(array $errors, array $internalErrors, ?array $dependencies, array $exportedNodes, bool $reachedInternalErrorsCountLimit)
    {
        $this->unorderedErrors = $errors;
        \usort($errors, static function (\_PhpScoperb75b35f52b74\PHPStan\Analyser\Error $a, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Error $b) : int {
            return [$a->getFile(), $a->getLine(), $a->getMessage()] <=> [$b->getFile(), $b->getLine(), $b->getMessage()];
        });
        $this->errors = $errors;
        $this->internalErrors = $internalErrors;
        $this->dependencies = $dependencies;
        $this->exportedNodes = $exportedNodes;
        $this->reachedInternalErrorsCountLimit = $reachedInternalErrorsCountLimit;
    }
    /**
     * @return \PHPStan\Analyser\Error[]
     */
    public function getUnorderedErrors() : array
    {
        return $this->unorderedErrors;
    }
    /**
     * @return \PHPStan\Analyser\Error[]
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
    /**
     * @return string[]
     */
    public function getInternalErrors() : array
    {
        return $this->internalErrors;
    }
    /**
     * @return array<string, array<string>>|null
     */
    public function getDependencies() : ?array
    {
        return $this->dependencies;
    }
    /**
     * @return array<string, array<ExportedNode>>
     */
    public function getExportedNodes() : array
    {
        return $this->exportedNodes;
    }
    public function hasReachedInternalErrorsCountLimit() : bool
    {
        return $this->reachedInternalErrorsCountLimit;
    }
}