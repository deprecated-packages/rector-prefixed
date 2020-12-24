<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait ConstFetchAnalyzerTrait
{
    /**
     * @var ConstFetchManipulator
     */
    private $constFetchManipulator;
    /**
     * @required
     */
    public function autowireConstFetchAnalyzerTrait(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator $constFetchManipulator) : void
    {
        $this->constFetchManipulator = $constFetchManipulator;
    }
    public function isFalse(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->constFetchManipulator->isFalse($node);
    }
    public function isTrue(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->constFetchManipulator->isTrue($node);
    }
    public function isBool(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->constFetchManipulator->isBool($node);
    }
    public function isNull(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->constFetchManipulator->isNull($node);
    }
}
