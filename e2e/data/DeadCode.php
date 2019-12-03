<?php declare(strict_types=1);

namespace Rector\E2E;

class DeadCode
{
    public function foo()
    {
        return 1;

        return 5;
    }
}
