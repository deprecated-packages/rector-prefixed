<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Console\Input;

use _PhpScoperbf340cb0be9d\Symfony\Component\Console\Input\ArgvInput;
class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \_PhpScoperbf340cb0be9d\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
