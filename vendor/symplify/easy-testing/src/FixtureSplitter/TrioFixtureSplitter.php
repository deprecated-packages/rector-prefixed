<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Symplify\EasyTesting\FixtureSplitter;

use RectorPrefix20210408\Nette\Utils\Strings;
use RectorPrefix20210408\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent;
use RectorPrefix20210408\Symplify\EasyTesting\ValueObject\SplitLine;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210408\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class TrioFixtureSplitter
{
    public function splitFileInfo(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \RectorPrefix20210408\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent
    {
        $parts = \RectorPrefix20210408\Nette\Utils\Strings::split($smartFileInfo->getContents(), \RectorPrefix20210408\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
        $this->ensureHasThreeParts($parts, $smartFileInfo);
        return new \RectorPrefix20210408\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent($parts[0], $parts[1], $parts[2]);
    }
    /**
     * @param mixed[] $parts
     */
    private function ensureHasThreeParts(array $parts, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        if (\count($parts) === 3) {
            return;
        }
        $message = \sprintf('The fixture "%s" should have 3 parts. %d found', $smartFileInfo->getRelativeFilePathFromCwd(), \count($parts));
        throw new \RectorPrefix20210408\Symplify\SymplifyKernel\Exception\ShouldNotHappenException($message);
    }
}
