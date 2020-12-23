<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Node\Constant;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
class ClassConstantFetch
{
    /** @var ClassConstFetch */
    private $node;
    /** @var Scope */
    private $scope;
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope)
    {
        $this->node = $node;
        $this->scope = $scope;
    }
    public function getNode() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->node;
    }
    public function getScope() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
