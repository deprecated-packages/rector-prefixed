<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Analyser;

class UndefinedVariableException extends \_PhpScopere8e811afab72\PHPStan\AnalysedCodeException
{
    /** @var \PHPStan\Analyser\Scope */
    private $scope;
    /** @var string */
    private $variableName;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, string $variableName)
    {
        parent::__construct(\sprintf('Undefined variable: $%s', $variableName));
        $this->scope = $scope;
        $this->variableName = $variableName;
    }
    public function getScope() : \_PhpScopere8e811afab72\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getVariableName() : string
    {
        return $this->variableName;
    }
    public function getTip() : ?string
    {
        return null;
    }
}
