<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObjectFactory;

use RectorPrefix20210407\Nette\Utils\Strings;
use Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration;
final class TagValueNodeConfigurationFactory
{
    /**
     * @var string
     * @see https://regex101.com/r/y3U6s4/1
     */
    public const NEWLINE_AFTER_OPENING_REGEX = '#^(\\(\\s+|\\n)#m';
    /**
     * @var string
     * @see https://regex101.com/r/bopnKI/1
     */
    public const NEWLINE_BEFORE_CLOSING_REGEX = '#(\\s+\\)|\\n(\\s+)?)$#m';
    public function createFromOriginalContent(?string $originalContent) : \Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration
    {
        if ($originalContent === null) {
            return new \Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration();
        }
        $hasNewlineAfterOpening = (bool) \RectorPrefix20210407\Nette\Utils\Strings::match($originalContent, self::NEWLINE_AFTER_OPENING_REGEX);
        $hasNewlineBeforeClosing = (bool) \RectorPrefix20210407\Nette\Utils\Strings::match($originalContent, self::NEWLINE_BEFORE_CLOSING_REGEX);
        return new \Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration($hasNewlineAfterOpening, $hasNewlineBeforeClosing);
    }
}
