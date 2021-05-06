<?php

declare (strict_types=1);
namespace RectorPrefix20210506\Symplify\EasyTesting\FixtureSplitter;

use RectorPrefix20210506\Nette\Utils\Strings;
use RectorPrefix20210506\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent;
use RectorPrefix20210506\Symplify\EasyTesting\ValueObject\SplitLine;
use Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210506\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class TrioFixtureSplitter
{
    public function splitFileInfo(\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \RectorPrefix20210506\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent
    {
        $parts = \RectorPrefix20210506\Nette\Utils\Strings::split($smartFileInfo->getContents(), \RectorPrefix20210506\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
        $this->ensureHasThreeParts($parts, $smartFileInfo);
        return new \RectorPrefix20210506\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent($parts[0], $parts[1], $parts[2]);
    }
    /**
     * @param mixed[] $parts
     */
    private function ensureHasThreeParts(array $parts, \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        if (\count($parts) === 3) {
            return;
        }
        $message = \sprintf('The fixture "%s" should have 3 parts. %d found', $smartFileInfo->getRelativeFilePathFromCwd(), \count($parts));
        throw new \RectorPrefix20210506\Symplify\SymplifyKernel\Exception\ShouldNotHappenException($message);
    }
}
