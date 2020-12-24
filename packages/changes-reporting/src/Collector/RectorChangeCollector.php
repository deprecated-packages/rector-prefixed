<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ChangesReporting\Collector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\ChangesReporting\ValueObject\RectorWithFileAndLineChange;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Logging\CurrentRectorProvider;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\Logging\CurrentRectorProvider $currentRectorProvider)
    {
        $this->currentRectorProvider = $currentRectorProvider;
    }
    /**
     * @return RectorWithFileAndLineChange[]
     */
    public function getRectorChangesByFileInfo(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : array
    {
        return \array_filter($this->rectorWithFileAndLineChanges, function (\_PhpScoperb75b35f52b74\Rector\ChangesReporting\ValueObject\RectorWithFileAndLineChange $rectorWithFileAndLineChange) use($smartFileInfo) : bool {
            return $rectorWithFileAndLineChange->getRealPath() === $smartFileInfo->getRealPath();
        });
    }
    public function notifyNodeFileInfo(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        $fileInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo === null) {
            // this file was changed before and this is a sub-new node
            // array Traverse to all new nodes would have to be used, but it's not worth the performance
            return;
        }
        $currentRector = $this->currentRectorProvider->getCurrentRector();
        if ($currentRector === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->addRectorClassWithLine($currentRector, $fileInfo, $node->getLine());
    }
    private function addRectorClassWithLine(\_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface $rector, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, int $line) : void
    {
        $this->rectorWithFileAndLineChanges[] = new \_PhpScoperb75b35f52b74\Rector\ChangesReporting\ValueObject\RectorWithFileAndLineChange($rector, $smartFileInfo->getRealPath(), $line);
    }
}
