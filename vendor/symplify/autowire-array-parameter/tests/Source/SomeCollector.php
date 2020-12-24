<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\AutowireArrayParameter\Tests\Source;

use _PhpScopere8e811afab72\Symplify\AutowireArrayParameter\Tests\Source\Contract\CollectedInterface;
final class SomeCollector
{
    /**
     * @var CollectedInterface[]
     */
    private $collected = [];
    /**
     * @param CollectedInterface[] $collected
     */
    public function __construct(array $collected)
    {
        $this->collected = $collected;
    }
    /**
     * @return CollectedInterface[]
     */
    public function getCollected() : array
    {
        return $this->collected;
    }
}
