<?php

declare (strict_types=1);
namespace RectorPrefix20210322\Doctrine\Persistence;

if (\interface_exists('Doctrine\\Persistence\\ObjectManager')) {
    return;
}
interface ObjectManager
{
}
