<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser;

class UndefinedVariableException extends \_PhpScoper2a4e7ab1ecbc\PHPStan\AnalysedCodeException
{
    /** @var \PHPStan\Analyser\Scope */
    private $scope;
    /** @var string */
    private $variableName;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope, string $variableName)
    {
        parent::__construct(\sprintf('Undefined variable: $%s', $variableName));
        $this->scope = $scope;
        $this->variableName = $variableName;
    }
    public function getScope() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope
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
