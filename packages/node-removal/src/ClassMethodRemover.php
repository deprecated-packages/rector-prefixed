<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeRemoval;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\DeadCode\NodeManipulator\LivingCodeManipulator;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScopere8e811afab72\Rector\NodeCollector\ValueObject\ArrayCallable;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScopere8e811afab72\Rector\NodeRemoval\NodeRemover $nodeRemover, \_PhpScopere8e811afab72\Rector\DeadCode\NodeManipulator\LivingCodeManipulator $livingCodeManipulator)
    {
        $this->nodeRepository = $nodeRepository;
        $this->nodeRemover = $nodeRemover;
        $this->livingCodeManipulator = $livingCodeManipulator;
    }
    public function removeClassMethodAndUsages(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->nodeRemover->removeNode($classMethod);
        $calls = $this->nodeRepository->findCallsByClassMethod($classMethod);
        foreach ($calls as $classMethodCall) {
            if ($classMethodCall instanceof \_PhpScopere8e811afab72\Rector\NodeCollector\ValueObject\ArrayCallable) {
                continue;
            }
            $this->removeMethodCall($classMethodCall);
        }
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function removeMethodCall(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        $currentStatement = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        foreach ($node->args as $arg) {
            $this->livingCodeManipulator->addLivingCodeBeforeNode($arg->value, $currentStatement);
        }
        $this->nodeRemover->removeNode($node);
    }
}
