<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeRemoval;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator\LivingCodeManipulator;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\ValueObject\ArrayCallable;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class ClassMethodRemover
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    /**
     * @var NodeRemover
     */
    private $nodeRemover;
    /**
     * @var LivingCodeManipulator
     */
    private $livingCodeManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScoper0a6b37af0871\Rector\NodeRemoval\NodeRemover $nodeRemover, \_PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator\LivingCodeManipulator $livingCodeManipulator)
    {
        $this->nodeRepository = $nodeRepository;
        $this->nodeRemover = $nodeRemover;
        $this->livingCodeManipulator = $livingCodeManipulator;
    }
    public function removeClassMethodAndUsages(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->nodeRemover->removeNode($classMethod);
        $calls = $this->nodeRepository->findCallsByClassMethod($classMethod);
        foreach ($calls as $classMethodCall) {
            if ($classMethodCall instanceof \_PhpScoper0a6b37af0871\Rector\NodeCollector\ValueObject\ArrayCallable) {
                continue;
            }
            $this->removeMethodCall($classMethodCall);
        }
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function removeMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : void
    {
        $currentStatement = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        foreach ($node->args as $arg) {
            $this->livingCodeManipulator->addLivingCodeBeforeNode($arg->value, $currentStatement);
        }
        $this->nodeRemover->removeNode($node);
    }
}
