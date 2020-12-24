<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\PhpDoc\PhpDocValueToNodeMapper;
final class ExpectExceptionMethodCallFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var PhpDocValueToNodeMapper
     */
    private $phpDocValueToNodeMapper;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoperb75b35f52b74\Rector\PHPUnit\PhpDoc\PhpDocValueToNodeMapper $phpDocValueToNodeMapper)
    {
        $this->nodeFactory = $nodeFactory;
        $this->phpDocValueToNodeMapper = $phpDocValueToNodeMapper;
    }
    /**
     * @param PhpDocTagNode[] $phpDocTagNodes
     * @return Expression[]
     */
    public function createFromTagValueNodes(array $phpDocTagNodes, string $methodName) : array
    {
        $methodCallExpressions = [];
        foreach ($phpDocTagNodes as $genericTagValueNode) {
            $methodCall = $this->createMethodCall($genericTagValueNode, $methodName);
            $methodCallExpressions[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($methodCall);
        }
        return $methodCallExpressions;
    }
    private function createMethodCall(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode $phpDocTagNode, string $methodName) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        if (!$phpDocTagNode->value instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $node = $this->phpDocValueToNodeMapper->mapGenericTagValueNode($phpDocTagNode->value);
        return $this->nodeFactory->createMethodCall('this', $methodName, [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($node)]);
    }
}
