<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\NodeRenamer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
final class MethodCallRenamer
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }
    public function updateClassMethodCalls(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $desiredMethodName) : void
    {
        /** @var MethodCall[] $methodCalls */
        $methodCalls = $this->nodeRepository->findCallsByClassMethod($classMethod);
        foreach ($methodCalls as $methodCall) {
            $methodCall->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($desiredMethodName);
        }
    }
}
