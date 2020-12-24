<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\ChangesReporting\Contract\Output;

use _PhpScoper0a6b37af0871\Rector\ChangesReporting\Application\ErrorAndDiffCollector;
interface OutputFormatterInterface
{
    public function getName() : string;
    public function report(\_PhpScoper0a6b37af0871\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector) : void;
}
