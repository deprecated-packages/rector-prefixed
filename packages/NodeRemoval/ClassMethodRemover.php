<?php

declare (strict_types=1);
namespace Rector\NodeRemoval;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\DeadCode\NodeManipulator\LivingCodeManipulator;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeCollector\ValueObject\ArrayCallable;
use Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \Rector\NodeRemoval\NodeRemover $nodeRemover, \Rector\DeadCode\NodeManipulator\LivingCodeManipulator $livingCodeManipulator)
    {
        $this->nodeRepository = $nodeRepository;
        $this->nodeRemover = $nodeRemover;
        $this->livingCodeManipulator = $livingCodeManipulator;
    }
    /**
     * @return void
     */
    public function removeClassMethodAndUsages(\PhpParser\Node\Stmt\ClassMethod $classMethod)
    {
        $this->nodeRemover->removeNode($classMethod);
        $calls = $this->nodeRepository->findCallsByClassMethod($classMethod);
        foreach ($calls as $call) {
            if ($call instanceof \Rector\NodeCollector\ValueObject\ArrayCallable) {
                continue;
            }
            $this->removeMethodCall($call);
        }
    }
    /**
     * @param MethodCall|StaticCall $node
     * @return void
     */
    private function removeMethodCall(\PhpParser\Node $node)
    {
        $currentStatement = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        foreach ($node->args as $arg) {
            $this->livingCodeManipulator->addLivingCodeBeforeNode($arg->value, $currentStatement);
        }
        $this->nodeRemover->removeNode($node);
    }
}
