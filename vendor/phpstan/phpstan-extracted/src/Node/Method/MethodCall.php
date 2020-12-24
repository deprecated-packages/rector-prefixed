<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node\Method;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
class MethodCall
{
    /** @var \PhpParser\Node\Expr\MethodCall|StaticCall|Array_ */
    private $node;
    /** @var Scope */
    private $scope;
    /**
     * @param \PhpParser\Node\Expr\MethodCall|StaticCall|Array_ $node
     * @param Scope $scope
     */
    public function __construct($node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope)
    {
        $this->node = $node;
        $this->scope = $scope;
    }
    /**
     * @return \PhpParser\Node\Expr\MethodCall|StaticCall|Array_
     */
    public function getNode()
    {
        return $this->node;
    }
    public function getScope() : \_PhpScopere8e811afab72\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
