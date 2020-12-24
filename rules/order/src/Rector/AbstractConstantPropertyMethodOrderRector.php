<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Order\Rector;

use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Order\StmtOrder;
use _PhpScoperb75b35f52b74\Rector\Order\StmtVisibilitySorter;
abstract class AbstractConstantPropertyMethodOrderRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
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
    public function autowireAbstractConstantPropertyMethodOrderRector(\_PhpScoperb75b35f52b74\Rector\Order\StmtOrder $stmtOrder, \_PhpScoperb75b35f52b74\Rector\Order\StmtVisibilitySorter $stmtVisibilitySorter) : void
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
