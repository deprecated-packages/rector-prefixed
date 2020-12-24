<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject;

use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
final class StartAndEnd
{
    /**
     * @var int
     */
    private $start;
    /**
     * @var int
     */
    private $end;
    public function __construct(int $start, int $end)
    {
        if ($end < $start) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->start = $start;
        $this->end = $end;
    }
    public function getStart() : int
    {
        return $this->start;
    }
    public function getEnd() : int
    {
        return $this->end;
    }
}
