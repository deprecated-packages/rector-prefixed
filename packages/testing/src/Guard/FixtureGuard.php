<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Testing\Guard;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\Testing\SuperfluousAfterContentFixtureException;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class FixtureGuard
{
    /**
     * @see https://regex101.com/r/xaNeNi/3
     * @var string
     */
    private const BEFORE_AFTER_CONTENT_REGEX = '#^(?<before_content>.*?)\\-\\-\\-\\-\\-\\n(?<after_content>.*?)$#s';
    public function ensureFileInfoHasDifferentBeforeAndAfterContent(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $match = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::match($smartFileInfo->getContents(), self::BEFORE_AFTER_CONTENT_REGEX);
        if ($match === null) {
            return;
        }
        $beforeContent = \trim($match['before_content']);
        $afterContent = \trim($match['after_content']);
        if ($beforeContent !== $afterContent) {
            return;
        }
        $exceptionMessage = \sprintf('The part after "-----" can be removed in "%s" file. It is the same as top half, so no change is required.', $smartFileInfo->getRelativeFilePathFromCwd());
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\Testing\SuperfluousAfterContentFixtureException($exceptionMessage);
    }
}
