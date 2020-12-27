<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Node\Constant;

use PhpParser\Node\Expr\ClassConstFetch;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
class ClassConstantFetch
{
    /** @var ClassConstFetch */
    private $node;
    /** @var Scope */
    private $scope;
    public function __construct(\PhpParser\Node\Expr\ClassConstFetch $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope)
    {
        $this->node = $node;
        $this->scope = $scope;
    }
    public function getNode() : \PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->node;
    }
    public function getScope() : \RectorPrefix20201227\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
