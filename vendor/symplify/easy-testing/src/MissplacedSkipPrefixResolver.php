<?php

declare (strict_types=1);
namespace RectorPrefix20210107\Symplify\EasyTesting;

use RectorPrefix20210107\Nette\Utils\Strings;
use RectorPrefix20210107\Symplify\EasyTesting\ValueObject\Prefix;
use RectorPrefix20210107\Symplify\EasyTesting\ValueObject\SplitLine;
use RectorPrefix20210107\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\EasyTesting\Tests\MissingSkipPrefixResolver\MissingSkipPrefixResolverTest
 */
final class MissplacedSkipPrefixResolver
{
    /**
     * @param SmartFileInfo[] $fixtureFileInfos
     * @return SmartFileInfo[]
     */
    public function resolve(array $fixtureFileInfos) : array
    {
        $invalidFileInfos = [];
        foreach ($fixtureFileInfos as $fixtureFileInfo) {
            $fileContents = $fixtureFileInfo->getContents();
            if (\RectorPrefix20210107\Nette\Utils\Strings::match($fileContents, \RectorPrefix20210107\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX)) {
                if ($this->hasNameSkipStart($fixtureFileInfo)) {
                    $invalidFileInfos[] = $fixtureFileInfo;
                }
                continue;
            }
            if ($this->hasNameSkipStart($fixtureFileInfo)) {
                continue;
            }
            $invalidFileInfos[] = $fixtureFileInfo;
        }
        return $invalidFileInfos;
    }
    private function hasNameSkipStart(\RectorPrefix20210107\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : bool
    {
        return (bool) \RectorPrefix20210107\Nette\Utils\Strings::match($fixtureFileInfo->getBasenameWithoutSuffix(), \RectorPrefix20210107\Symplify\EasyTesting\ValueObject\Prefix::SKIP_PREFIX_REGEX);
    }
}
