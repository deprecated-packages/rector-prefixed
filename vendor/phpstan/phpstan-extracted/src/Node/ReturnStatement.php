<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Node;

use PhpParser\Node\Stmt\Return_;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
class ReturnStatement
{
    /** @var Scope */
    private $scope;
    /** @var \PhpParser\Node\Stmt\Return_ */
    private $returnNode;
    public function __construct(\RectorPrefix20201227\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Stmt\Return_ $returnNode)
    {
        $this->scope = $scope;
        $this->returnNode = $returnNode;
    }
    public function getScope() : \RectorPrefix20201227\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getReturnNode() : \PhpParser\Node\Stmt\Return_
    {
        return $this->returnNode;
    }
}
