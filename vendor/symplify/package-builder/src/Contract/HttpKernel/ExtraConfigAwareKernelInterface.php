<?php

declare (strict_types=1);
namespace RectorPrefix20201229\Symplify\PackageBuilder\Contract\HttpKernel;

use RectorPrefix20201229\Symfony\Component\HttpKernel\KernelInterface;
use RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \RectorPrefix20201229\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
