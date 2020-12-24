<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
class ReturnStatement
{
    /** @var Scope */
    private $scope;
    /** @var \PhpParser\Node\Stmt\Return_ */
    private $returnNode;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ $returnNode)
    {
        $this->scope = $scope;
        $this->returnNode = $returnNode;
    }
    public function getScope() : \_PhpScopere8e811afab72\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getReturnNode() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_
    {
        return $this->returnNode;
    }
}
