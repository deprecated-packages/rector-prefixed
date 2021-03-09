<?php

declare (strict_types=1);
namespace RectorPrefix20210309\Symplify\PackageBuilder\Contract\HttpKernel;

use RectorPrefix20210309\Symfony\Component\HttpKernel\KernelInterface;
use RectorPrefix20210309\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \RectorPrefix20210309\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
