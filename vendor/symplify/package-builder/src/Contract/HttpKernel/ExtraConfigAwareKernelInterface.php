<?php

declare (strict_types=1);
namespace RectorPrefix20210317\Symplify\PackageBuilder\Contract\HttpKernel;

use RectorPrefix20210317\Symfony\Component\HttpKernel\KernelInterface;
use RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \RectorPrefix20210317\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
