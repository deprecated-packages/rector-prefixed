<?php

declare (strict_types=1);
namespace RectorPrefix20210204\Symplify\PackageBuilder\Contract\HttpKernel;

use RectorPrefix20210204\Symfony\Component\HttpKernel\KernelInterface;
use RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \RectorPrefix20210204\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
