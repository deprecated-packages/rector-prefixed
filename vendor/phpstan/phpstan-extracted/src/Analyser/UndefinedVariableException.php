<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Analyser;

class UndefinedVariableException extends \_PhpScoper0a2ac50786fa\PHPStan\AnalysedCodeException
{
    /** @var \PHPStan\Analyser\Scope */
    private $scope;
    /** @var string */
    private $variableName;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, string $variableName)
    {
        parent::__construct(\sprintf('Undefined variable: $%s', $variableName));
        $this->scope = $scope;
        $this->variableName = $variableName;
    }
    public function getScope() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope
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
