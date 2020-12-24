<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\PHPUnit\PhpDoc\PhpDocValueToNodeMapper;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScopere8e811afab72\Rector\PHPUnit\PhpDoc\PhpDocValueToNodeMapper $phpDocValueToNodeMapper)
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
            $methodCallExpressions[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($methodCall);
        }
        return $methodCallExpressions;
    }
    private function createMethodCall(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode $phpDocTagNode, string $methodName) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        if (!$phpDocTagNode->value instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $node = $this->phpDocValueToNodeMapper->mapGenericTagValueNode($phpDocTagNode->value);
        return $this->nodeFactory->createMethodCall('this', $methodName, [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($node)]);
    }
}
