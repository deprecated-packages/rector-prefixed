<?php

declare (strict_types=1);
namespace Rector\Core\Contract\Processor;

use Rector\Core\ValueObject\NonPhpFile\NonPhpFileChange;
use RectorPrefix20210412\Symplify\SmartFileSystem\SmartFileInfo;
interface FileProcessorInterface
{
    public function process(\RectorPrefix20210412\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : ?\Rector\Core\ValueObject\NonPhpFile\NonPhpFileChange;
    public function supports(\RectorPrefix20210412\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool;
    /**
     * @return string[]
     */
    public function getSupportedFileExtensions() : array;
}
