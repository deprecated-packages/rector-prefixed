<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\Input;

use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\ArgvInput;
class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
