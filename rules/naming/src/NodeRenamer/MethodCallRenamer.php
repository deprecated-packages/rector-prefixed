<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\NodeRenamer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository;
final class MethodCallRenamer
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }
    public function updateClassMethodCalls(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, string $desiredMethodName) : void
    {
        /** @var MethodCall[] $methodCalls */
        $methodCalls = $this->nodeRepository->findCallsByClassMethod($classMethod);
        foreach ($methodCalls as $methodCall) {
            $methodCall->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier($desiredMethodName);
        }
    }
}
