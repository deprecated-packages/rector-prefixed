<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\ValueObjectFactory;

use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\Core\Differ\DefaultDiffer;
use Rector\Core\ValueObject\Application\File;
use Rector\Core\ValueObject\Reporting\FileDiff;
use RectorPrefix20210412\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer;
final class FileDiffFactory
{
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    /**
     * @var DefaultDiffer
     */
    private $defaultDiffer;
    /**
     * @var ConsoleDiffer
     */
    private $consoleDiffer;
    public function __construct(\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \Rector\Core\Differ\DefaultDiffer $defaultDiffer, \RectorPrefix20210412\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer $consoleDiffer)
    {
        $this->rectorChangeCollector = $rectorChangeCollector;
        $this->defaultDiffer = $defaultDiffer;
        $this->consoleDiffer = $consoleDiffer;
    }
    public function createFileDiff(\Rector\Core\ValueObject\Application\File $file, string $oldContent, string $newContent) : \Rector\Core\ValueObject\Reporting\FileDiff
    {
        $smartFileInfo = $file->getSmartFileInfo();
        $rectorChanges = $this->rectorChangeCollector->getRectorChangesByFileInfo($smartFileInfo);
        // always keep the most recent diff
        return new \Rector\Core\ValueObject\Reporting\FileDiff($smartFileInfo, $this->defaultDiffer->diff($oldContent, $newContent), $this->consoleDiffer->diff($oldContent, $newContent), $rectorChanges);
    }
}
