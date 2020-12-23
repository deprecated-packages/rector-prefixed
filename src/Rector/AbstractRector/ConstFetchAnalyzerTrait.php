<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator;
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
    public function autowireConstFetchAnalyzerTrait(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator $constFetchManipulator) : void
    {
        $this->constFetchManipulator = $constFetchManipulator;
    }
    public function isFalse(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        return $this->constFetchManipulator->isFalse($node);
    }
    public function isTrue(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        return $this->constFetchManipulator->isTrue($node);
    }
    public function isBool(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        return $this->constFetchManipulator->isBool($node);
    }
    public function isNull(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        return $this->constFetchManipulator->isNull($node);
    }
}
