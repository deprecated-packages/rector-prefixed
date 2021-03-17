<?php

declare (strict_types=1);
namespace Rector\Core\Exception\Application;

use Exception;
use RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileInfo;
use Throwable;
final class FileProcessingException extends \Exception
{
    /**
     * @param \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo
     * @param \Throwable $throwable
     */
    public function __construct($smartFileInfo, $throwable)
    {
        $message = \sprintf('Processing file "%s" failed. %s%s', $smartFileInfo->getRealPath(), \PHP_EOL . \PHP_EOL, $throwable);
        parent::__construct($message);
    }
}
