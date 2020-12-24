<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;

use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait NodeCollectorTrait
{
    /**
     * @var NodeRepository
     */
    protected $nodeRepository;
    /**
     * @required
     */
    public function autowireNodeCollectorTrait(\_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository) : void
    {
        $this->nodeRepository = $nodeRepository;
    }
}
