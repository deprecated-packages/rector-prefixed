<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Input;

use _PhpScopere8e811afab72\Symfony\Component\Console\Input\ArgvInput;
class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \_PhpScopere8e811afab72\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
