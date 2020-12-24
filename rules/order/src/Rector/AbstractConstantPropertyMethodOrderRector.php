<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Order\Rector;

use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Order\StmtOrder;
use _PhpScoper0a6b37af0871\Rector\Order\StmtVisibilitySorter;
abstract class AbstractConstantPropertyMethodOrderRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
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
    public function autowireAbstractConstantPropertyMethodOrderRector(\_PhpScoper0a6b37af0871\Rector\Order\StmtOrder $stmtOrder, \_PhpScoper0a6b37af0871\Rector\Order\StmtVisibilitySorter $stmtVisibilitySorter) : void
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
