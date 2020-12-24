<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\ChangesReporting\Contract\Output;

use _PhpScopere8e811afab72\Rector\ChangesReporting\Application\ErrorAndDiffCollector;
interface OutputFormatterInterface
{
    public function getName() : string;
    public function report(\_PhpScopere8e811afab72\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector) : void;
}
