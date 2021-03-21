<?php

declare (strict_types=1);
namespace RectorPrefix20210321\PHPUnit\Framework;

if (\interface_exists('PHPUnit\\Framework\\TestListener')) {
    return;
}
interface TestListener
{
}
