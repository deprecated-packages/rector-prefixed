<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\AutowireArrayParameter\Tests\Source;

use _PhpScoper0a6b37af0871\Symplify\AutowireArrayParameter\Tests\Source\Contract\CollectedInterface;
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
