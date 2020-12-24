<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Node\Method;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
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
    public function __construct($node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope)
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
    public function getScope() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
