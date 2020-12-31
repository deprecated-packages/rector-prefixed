<?php

declare (strict_types=1);
namespace RectorPrefix20201231\Symplify\PackageBuilder\Contract\HttpKernel;

use RectorPrefix20201231\Symfony\Component\HttpKernel\KernelInterface;
use RectorPrefix20201231\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \RectorPrefix20201231\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
