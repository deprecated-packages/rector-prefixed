<?php

declare (strict_types=1);
namespace Rector\Core\Contract\Rector;

if (\interface_exists(\Rector\Core\Contract\Rector\RectorInterface::class)) {
    return;
}
interface RectorInterface
{
}
