<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\Contract\Output;

use Rector\Core\ValueObject\ProcessResult;
interface OutputFormatterInterface
{
    public function getName() : string;
    /**
     * @return void
     */
    public function report(\Rector\Core\ValueObject\ProcessResult $processResult);
}
