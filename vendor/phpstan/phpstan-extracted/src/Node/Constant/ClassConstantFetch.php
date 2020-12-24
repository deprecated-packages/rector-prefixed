<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node\Constant;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
class ClassConstantFetch
{
    /** @var ClassConstFetch */
    private $node;
    /** @var Scope */
    private $scope;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope)
    {
        $this->node = $node;
        $this->scope = $scope;
    }
    public function getNode() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->node;
    }
    public function getScope() : \_PhpScopere8e811afab72\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
