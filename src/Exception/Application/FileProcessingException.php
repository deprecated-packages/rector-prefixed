<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Exception\Application;

use Exception;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use Throwable;
final class FileProcessingException extends \Exception
{
    public function __construct(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \Throwable $throwable)
    {
        $message = \sprintf('Processing file "%s" failed. %s%s', $smartFileInfo->getRealPath(), \PHP_EOL . \PHP_EOL, $throwable);
        parent::__construct($message);
    }
}
