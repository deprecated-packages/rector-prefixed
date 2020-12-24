<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeRemoval;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\DeadCode\NodeManipulator\LivingCodeManipulator;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\ValueObject\ArrayCallable;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScoperb75b35f52b74\Rector\NodeRemoval\NodeRemover $nodeRemover, \_PhpScoperb75b35f52b74\Rector\DeadCode\NodeManipulator\LivingCodeManipulator $livingCodeManipulator)
    {
        $this->nodeRepository = $nodeRepository;
        $this->nodeRemover = $nodeRemover;
        $this->livingCodeManipulator = $livingCodeManipulator;
    }
    public function removeClassMethodAndUsages(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->nodeRemover->removeNode($classMethod);
        $calls = $this->nodeRepository->findCallsByClassMethod($classMethod);
        foreach ($calls as $classMethodCall) {
            if ($classMethodCall instanceof \_PhpScoperb75b35f52b74\Rector\NodeCollector\ValueObject\ArrayCallable) {
                continue;
            }
            $this->removeMethodCall($classMethodCall);
        }
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function removeMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        $currentStatement = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        foreach ($node->args as $arg) {
            $this->livingCodeManipulator->addLivingCodeBeforeNode($arg->value, $currentStatement);
        }
        $this->nodeRemover->removeNode($node);
    }
}
