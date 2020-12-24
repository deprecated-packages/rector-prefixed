<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Contract\HttpKernel;

use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\KernelInterface;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
