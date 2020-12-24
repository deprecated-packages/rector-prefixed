<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Input;

use _PhpScoperb75b35f52b74\Symfony\Component\Console\Input\ArgvInput;
class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
