<?php

declare (strict_types=1);
namespace RectorPrefix20210321\Symfony\Bundle\FrameworkBundle\Kernel;

if (\class_exists('Symfony\\Bundle\\FrameworkBundle\\Kernel\\MicroKernelTrait')) {
    return;
}
trait MicroKernelTrait
{
}
