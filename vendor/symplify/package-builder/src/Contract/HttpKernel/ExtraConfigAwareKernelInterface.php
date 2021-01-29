<?php

declare (strict_types=1);
namespace RectorPrefix20210129\Symplify\PackageBuilder\Contract\HttpKernel;

use RectorPrefix20210129\Symfony\Component\HttpKernel\KernelInterface;
use RectorPrefix20210129\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \RectorPrefix20210129\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
