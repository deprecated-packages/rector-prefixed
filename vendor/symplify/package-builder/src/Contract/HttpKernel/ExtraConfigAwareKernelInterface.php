<?php

declare (strict_types=1);
namespace RectorPrefix20210422\Symplify\PackageBuilder\Contract\HttpKernel;

use RectorPrefix20210422\Symfony\Component\HttpKernel\KernelInterface;
use RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \RectorPrefix20210422\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     * @return void
     */
    public function setConfigs(array $configs);
}
