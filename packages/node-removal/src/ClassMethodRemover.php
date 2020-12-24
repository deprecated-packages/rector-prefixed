<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeRemoval;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\Rector\DeadCode\NodeManipulator\LivingCodeManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\ValueObject\ArrayCallable;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScoper2a4e7ab1ecbc\Rector\NodeRemoval\NodeRemover $nodeRemover, \_PhpScoper2a4e7ab1ecbc\Rector\DeadCode\NodeManipulator\LivingCodeManipulator $livingCodeManipulator)
    {
        $this->nodeRepository = $nodeRepository;
        $this->nodeRemover = $nodeRemover;
        $this->livingCodeManipulator = $livingCodeManipulator;
    }
    public function removeClassMethodAndUsages(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->nodeRemover->removeNode($classMethod);
        $calls = $this->nodeRepository->findCallsByClassMethod($classMethod);
        foreach ($calls as $classMethodCall) {
            if ($classMethodCall instanceof \_PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\ValueObject\ArrayCallable) {
                continue;
            }
            $this->removeMethodCall($classMethodCall);
        }
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function removeMethodCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $currentStatement = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        foreach ($node->args as $arg) {
            $this->livingCodeManipulator->addLivingCodeBeforeNode($arg->value, $currentStatement);
        }
        $this->nodeRemover->removeNode($node);
    }
}
