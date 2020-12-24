<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Node\Constant;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
class ClassConstantFetch
{
    /** @var ClassConstFetch */
    private $node;
    /** @var Scope */
    private $scope;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope)
    {
        $this->node = $node;
        $this->scope = $scope;
    }
    public function getNode() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->node;
    }
    public function getScope() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
