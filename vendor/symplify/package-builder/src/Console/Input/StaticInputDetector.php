<?php

declare (strict_types=1);
namespace RectorPrefix20210428\Symplify\PackageBuilder\Console\Input;

use RectorPrefix20210428\Symfony\Component\Console\Input\ArgvInput;
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \RectorPrefix20210428\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
