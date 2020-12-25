<?php

declare (strict_types=1);
namespace Rector\Naming\Contract\Guard;

interface ConflictingGuardAwareInterface
{
    public function provideGuard() : \Rector\Naming\Contract\Guard\ConflictingGuardInterface;
}
