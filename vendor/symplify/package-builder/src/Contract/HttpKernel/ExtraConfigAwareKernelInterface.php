<?php

declare (strict_types=1);
namespace RectorPrefix20210112\Symplify\PackageBuilder\Contract\HttpKernel;

use RectorPrefix20210112\Symfony\Component\HttpKernel\KernelInterface;
use RectorPrefix20210112\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \RectorPrefix20210112\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
