<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Exception\Application;

use Exception;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
use Throwable;
final class FileProcessingException extends \Exception
{
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \Throwable $throwable)
    {
        $message = \sprintf('Processing file "%s" failed. %s%s', $smartFileInfo->getRealPath(), \PHP_EOL . \PHP_EOL, $throwable);
        parent::__construct($message);
    }
}
