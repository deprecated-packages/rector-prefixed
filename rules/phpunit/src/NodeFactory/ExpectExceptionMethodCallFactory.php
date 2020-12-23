<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\NodeFactory;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\PhpDoc\PhpDocValueToNodeMapper;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper0a2ac50786fa\Rector\PHPUnit\PhpDoc\PhpDocValueToNodeMapper $phpDocValueToNodeMapper)
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
            $methodCallExpressions[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($methodCall);
        }
        return $methodCallExpressions;
    }
    private function createMethodCall(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode $phpDocTagNode, string $methodName) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        if (!$phpDocTagNode->value instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        $node = $this->phpDocValueToNodeMapper->mapGenericTagValueNode($phpDocTagNode->value);
        return $this->nodeFactory->createMethodCall('this', $methodName, [new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($node)]);
    }
}
