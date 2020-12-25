<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\Contract\Output;

use Rector\ChangesReporting\Application\ErrorAndDiffCollector;
interface OutputFormatterInterface
{
    public function getName() : string;
    public function report(\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector) : void;
}
