<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject;

use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
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
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
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
