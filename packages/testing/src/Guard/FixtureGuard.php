<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Testing\Guard;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\Testing\SuperfluousAfterContentFixtureException;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class FixtureGuard
{
    /**
     * @see https://regex101.com/r/xaNeNi/3
     * @var string
     */
    private const BEFORE_AFTER_CONTENT_REGEX = '#^(?<before_content>.*?)\\-\\-\\-\\-\\-\\n(?<after_content>.*?)$#s';
    public function ensureFileInfoHasDifferentBeforeAndAfterContent(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $match = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::match($smartFileInfo->getContents(), self::BEFORE_AFTER_CONTENT_REGEX);
        if ($match === null) {
            return;
        }
        $beforeContent = \trim($match['before_content']);
        $afterContent = \trim($match['after_content']);
        if ($beforeContent !== $afterContent) {
            return;
        }
        $exceptionMessage = \sprintf('The part after "-----" can be removed in "%s" file. It is the same as top half, so no change is required.', $smartFileInfo->getRelativeFilePathFromCwd());
        throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\Testing\SuperfluousAfterContentFixtureException($exceptionMessage);
    }
}
