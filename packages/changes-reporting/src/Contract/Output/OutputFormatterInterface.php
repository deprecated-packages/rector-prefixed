<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ChangesReporting\Contract\Output;

use _PhpScoperb75b35f52b74\Rector\ChangesReporting\Application\ErrorAndDiffCollector;
interface OutputFormatterInterface
{
    public function getName() : string;
    public function report(\_PhpScoperb75b35f52b74\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector) : void;
}
