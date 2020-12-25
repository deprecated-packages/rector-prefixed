<?php

declare (strict_types=1);
namespace PHPStan\Node\Constant;

use PhpParser\Node\Expr\ClassConstFetch;
use PHPStan\Analyser\Scope;
class ClassConstantFetch
{
    /** @var ClassConstFetch */
    private $node;
    /** @var Scope */
    private $scope;
    public function __construct(\PhpParser\Node\Expr\ClassConstFetch $node, \PHPStan\Analyser\Scope $scope)
    {
        $this->node = $node;
        $this->scope = $scope;
    }
    public function getNode() : \PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->node;
    }
    public function getScope() : \PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
