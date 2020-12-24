<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
class ReturnStatement
{
    /** @var Scope */
    private $scope;
    /** @var \PhpParser\Node\Stmt\Return_ */
    private $returnNode;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ $returnNode)
    {
        $this->scope = $scope;
        $this->returnNode = $returnNode;
    }
    public function getScope() : \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getReturnNode() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_
    {
        return $this->returnNode;
    }
}
