<?php

declare (strict_types=1);
namespace Rector\Reporting\DataCollector;

use PhpParser\Node;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Reporting\ValueObject\Report;
final class ReportCollector
{
    /**
     * @var Report[]
     */
    private $reports = [];
    public function addFileAndLineAwareReport(string $report, \PhpParser\Node $node, string $rectorClass) : void
    {
        $smartFileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($smartFileInfo === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->reports[] = new \Rector\Reporting\ValueObject\Report($report, $rectorClass, $smartFileInfo, $node->getLine());
    }
    /**
     * @return Report[]
     */
    public function getReports() : array
    {
        return $this->reports;
    }
}
