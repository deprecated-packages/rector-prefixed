<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\AutowireArrayParameter\Tests\Source;

use _PhpScoper2a4e7ab1ecbc\Symplify\AutowireArrayParameter\Tests\Source\Contract\CollectedInterface;
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
