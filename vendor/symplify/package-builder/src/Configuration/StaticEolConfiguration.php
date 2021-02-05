<?php

declare (strict_types=1);
namespace RectorPrefix20210205\Symplify\PackageBuilder\Configuration;

final class StaticEolConfiguration
{
    public static function getEolChar() : string
    {
        return "\n";
    }
}
