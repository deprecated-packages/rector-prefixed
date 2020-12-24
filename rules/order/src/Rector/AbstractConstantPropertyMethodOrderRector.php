<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Order\Rector;

use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Order\StmtOrder;
use _PhpScopere8e811afab72\Rector\Order\StmtVisibilitySorter;
abstract class AbstractConstantPropertyMethodOrderRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var StmtOrder
     */
    protected $stmtOrder;
    /**
     * @var StmtVisibilitySorter
     */
    protected $stmtVisibilitySorter;
    /**
     * @required
     */
    public function autowireAbstractConstantPropertyMethodOrderRector(\_PhpScopere8e811afab72\Rector\Order\StmtOrder $stmtOrder, \_PhpScopere8e811afab72\Rector\Order\StmtVisibilitySorter $stmtVisibilitySorter) : void
    {
        $this->stmtOrder = $stmtOrder;
        $this->stmtVisibilitySorter = $stmtVisibilitySorter;
    }
    /**
     * @param array<int, int> $oldToNewKeys
     */
    public function hasOrderChanged(array $oldToNewKeys) : bool
    {
        return \array_keys($oldToNewKeys) !== \array_values($oldToNewKeys);
    }
}
