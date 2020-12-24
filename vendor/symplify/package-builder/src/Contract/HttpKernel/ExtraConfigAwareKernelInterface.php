<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Contract\HttpKernel;

use _PhpScoper0a6b37af0871\Symfony\Component\HttpKernel\KernelInterface;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \_PhpScoper0a6b37af0871\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
