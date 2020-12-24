<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Analyser;

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
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Analyser\MutatingScope $scope, array $specifiedExpressions)
    {
        $this->scope = $scope;
        $this->specifiedExpressions = $specifiedExpressions;
    }
    public function getScope() : \_PhpScopere8e811afab72\PHPStan\Analyser\MutatingScope
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
