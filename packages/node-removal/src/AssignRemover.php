<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeRemoval;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScoperb75b35f52b74\Rector\DeadCode\NodeManipulator\LivingCodeManipulator;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToReplaceCollector;
final class AssignRemover
{
    /**
     * @var NodesToReplaceCollector
     */
    private $nodesToReplaceCollector;
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    /**
     * @var NodeRemover
     */
    private $nodeRemover;
    /**
     * @var LivingCodeManipulator
     */
    private $livingCodeManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToReplaceCollector $nodesToReplaceCollector, \_PhpScoperb75b35f52b74\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \_PhpScoperb75b35f52b74\Rector\NodeRemoval\NodeRemover $nodeRemover, \_PhpScoperb75b35f52b74\Rector\DeadCode\NodeManipulator\LivingCodeManipulator $livingCodeManipulator)
    {
        $this->nodesToReplaceCollector = $nodesToReplaceCollector;
        $this->rectorChangeCollector = $rectorChangeCollector;
        $this->nodeRemover = $nodeRemover;
        $this->livingCodeManipulator = $livingCodeManipulator;
    }
    public function removeAssignNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : void
    {
        $currentStatement = $assign->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        $this->livingCodeManipulator->addLivingCodeBeforeNode($assign->var, $currentStatement);
        /** @var Assign $assign */
        $parent = $assign->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            $this->livingCodeManipulator->addLivingCodeBeforeNode($assign->expr, $currentStatement);
            $this->nodeRemover->removeNode($assign);
        } else {
            $this->nodesToReplaceCollector->addReplaceNodeWithAnotherNode($assign, $assign->expr);
            $this->rectorChangeCollector->notifyNodeFileInfo($assign->expr);
        }
    }
}
