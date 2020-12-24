<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Node;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
class ReturnStatement
{
    /** @var Scope */
    private $scope;
    /** @var \PhpParser\Node\Stmt\Return_ */
    private $returnNode;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_ $returnNode)
    {
        $this->scope = $scope;
        $this->returnNode = $returnNode;
    }
    public function getScope() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getReturnNode() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_
    {
        return $this->returnNode;
    }
}
