<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\Collector;

use PhpParser\Node;
use Rector\ChangesReporting\ValueObject\RectorWithFileAndLineChange;
use Rector\ChangesReporting\ValueObject\RectorWithLineChange;
use Rector\Core\Contract\Rector\RectorInterface;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Logging\CurrentRectorProvider;
use Rector\Core\Provider\CurrentFileProvider;
use Rector\Core\ValueObject\Application\File;
use RectorPrefix20210413\Symplify\SmartFileSystem\SmartFileInfo;
final class RectorChangeCollector
{
    /**
     * @var RectorWithFileAndLineChange[]
     */
    private $rectorWithFileAndLineChanges = [];
    /**
     * @var CurrentRectorProvider
     */
    private $currentRectorProvider;
    /**
     * @var CurrentFileProvider
     */
    private $currentFileProvider;
    public function __construct(\Rector\Core\Logging\CurrentRectorProvider $currentRectorProvider, \Rector\Core\Provider\CurrentFileProvider $currentFileProvider)
    {
        $this->currentRectorProvider = $currentRectorProvider;
        $this->currentFileProvider = $currentFileProvider;
    }
    /**
     * @return RectorWithFileAndLineChange[]
     */
    public function getRectorChangesByFileInfo(\RectorPrefix20210413\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : array
    {
        return \array_filter($this->rectorWithFileAndLineChanges, function (\Rector\ChangesReporting\ValueObject\RectorWithFileAndLineChange $rectorWithFileAndLineChange) use($smartFileInfo) : bool {
            return $rectorWithFileAndLineChange->getRealPath() === $smartFileInfo->getRealPath();
        });
    }
    public function notifyNodeFileInfo(\PhpParser\Node $node) : void
    {
        $file = $this->currentFileProvider->getFile();
        if (!$file instanceof \Rector\Core\ValueObject\Application\File) {
            // this file was changed before and this is a sub-new node
            // array Traverse to all new nodes would have to be used, but it's not worth the performance
            return;
        }
        $smartFileInfo = $file->getSmartFileInfo();
        $currentRector = $this->currentRectorProvider->getCurrentRector();
        if (!$currentRector instanceof \Rector\Core\Contract\Rector\RectorInterface) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // @old
        $this->addRectorClassWithLine($currentRector, $smartFileInfo, $node->getLine());
        // @new
        $rectorWithLineChange = new \Rector\ChangesReporting\ValueObject\RectorWithLineChange($currentRector, $node->getLine());
        $file->addRectorClassWithLine($rectorWithLineChange);
    }
    private function addRectorClassWithLine(\Rector\Core\Contract\Rector\RectorInterface $rector, \RectorPrefix20210413\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, int $line) : void
    {
        $this->rectorWithFileAndLineChanges[] = new \Rector\ChangesReporting\ValueObject\RectorWithFileAndLineChange($rector, $smartFileInfo->getRealPath(), $line);
    }
}
