<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node\Constant;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
class ClassConstantFetch
{
    /** @var ClassConstFetch */
    private $node;
    /** @var Scope */
    private $scope;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope)
    {
        $this->node = $node;
        $this->scope = $scope;
    }
    public function getNode() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->node;
    }
    public function getScope() : \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
