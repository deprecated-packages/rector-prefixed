<?php

declare(strict_types=1);

namespace Rector\BetterPhpDocParser\DataProvider;

use Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator;

final class CurrentTokenIteratorProvider
{
    /**
     * @var BetterTokenIterator
     */
    private $betterTokenIterator;

    /**
     * @return void
     */
    public function setBetterTokenIterator(BetterTokenIterator $betterTokenIterator)
    {
        $this->betterTokenIterator = $betterTokenIterator;
    }

    public function provide(): BetterTokenIterator
    {
        return $this->betterTokenIterator;
    }
}
