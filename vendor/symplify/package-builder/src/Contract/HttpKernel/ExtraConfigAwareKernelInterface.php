<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PackageBuilder\Contract\HttpKernel;

use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\KernelInterface;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \_PhpScopere8e811afab72\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
