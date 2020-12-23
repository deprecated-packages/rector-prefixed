<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\Skipper\SkipVoter;

use _PhpScoper0a2ac50786fa\Symplify\Skipper\Contract\SkipVoterInterface;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Matcher\FileInfoMatcher;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\SkipCriteriaResolver\SkippedMessagesResolver;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class MessageSkipVoter implements \_PhpScoper0a2ac50786fa\Symplify\Skipper\Contract\SkipVoterInterface
{
    /**
     * @var SkippedMessagesResolver
     */
    private $skippedMessagesResolver;
    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\Skipper\SkipCriteriaResolver\SkippedMessagesResolver $skippedMessagesResolver, \_PhpScoper0a2ac50786fa\Symplify\Skipper\Matcher\FileInfoMatcher $fileInfoMatcher)
    {
        $this->skippedMessagesResolver = $skippedMessagesResolver;
        $this->fileInfoMatcher = $fileInfoMatcher;
    }
    /**
     * @param string|object $element
     */
    public function match($element) : bool
    {
        if (\is_object($element)) {
            return \false;
        }
        return \substr_count($element, ' ') > 0;
    }
    /**
     * @param string $element
     */
    public function shouldSkip($element, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $skippedMessages = $this->skippedMessagesResolver->resolve();
        if (!\array_key_exists($element, $skippedMessages)) {
            return \false;
        }
        // skip regardless the path
        $skippedPaths = $skippedMessages[$element];
        if ($skippedPaths === null) {
            return \true;
        }
        return $this->fileInfoMatcher->doesFileInfoMatchPatterns($smartFileInfo, $skippedPaths);
    }
}
