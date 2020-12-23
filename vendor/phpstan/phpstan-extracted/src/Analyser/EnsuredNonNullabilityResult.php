<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Analyser;

class EnsuredNonNullabilityResult
{
    /** @var MutatingScope */
    private $scope;
    /** @var EnsuredNonNullabilityResultExpression[] */
    private $specifiedExpressions;
    /**
     * @param MutatingScope $scope
     * @param EnsuredNonNullabilityResultExpression[] $specifiedExpressions
     */
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\MutatingScope $scope, array $specifiedExpressions)
    {
        $this->scope = $scope;
        $this->specifiedExpressions = $specifiedExpressions;
    }
    public function getScope() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
    /**
     * @return EnsuredNonNullabilityResultExpression[]
     */
    public function getSpecifiedExpressions() : array
    {
        return $this->specifiedExpressions;
    }
}
