<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Console\Input;

use RectorPrefix2020DecSat\Symfony\Component\Console\Input\ArgvInput;
class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \RectorPrefix2020DecSat\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
