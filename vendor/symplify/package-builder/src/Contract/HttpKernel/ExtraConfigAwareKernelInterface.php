<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Contract\HttpKernel;

use _PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\KernelInterface;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \_PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
