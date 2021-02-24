<?php

declare (strict_types=1);
namespace RectorPrefix20210224\Symplify\PackageBuilder\Contract\HttpKernel;

use RectorPrefix20210224\Symfony\Component\HttpKernel\KernelInterface;
use RectorPrefix20210224\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \RectorPrefix20210224\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
