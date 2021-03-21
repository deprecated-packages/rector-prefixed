<?php

declare (strict_types=1);
namespace RectorPrefix20210321\Kdyby\Events;

if (\interface_exists('Kdyby\\Events\\Subscriber')) {
    return;
}
interface Subscriber
{
}
