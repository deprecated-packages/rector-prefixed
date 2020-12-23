<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\ChangesReporting\Contract\Output;

use _PhpScoper0a2ac50786fa\Rector\ChangesReporting\Application\ErrorAndDiffCollector;
interface OutputFormatterInterface
{
    public function getName() : string;
    public function report(\_PhpScoper0a2ac50786fa\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector) : void;
}
