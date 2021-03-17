<?php

declare (strict_types=1);
namespace RectorPrefix20210317\Symplify\Skipper\SkipVoter;

use RectorPrefix20210317\Symplify\Skipper\Contract\SkipVoterInterface;
use RectorPrefix20210317\Symplify\Skipper\Matcher\FileInfoMatcher;
use RectorPrefix20210317\Symplify\Skipper\SkipCriteriaResolver\SkippedMessagesResolver;
use RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileInfo;
final class MessageSkipVoter implements \RectorPrefix20210317\Symplify\Skipper\Contract\SkipVoterInterface
{
    /**
     * @var SkippedMessagesResolver
     */
    private $skippedMessagesResolver;
    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;
    /**
     * @param \Symplify\Skipper\SkipCriteriaResolver\SkippedMessagesResolver $skippedMessagesResolver
     * @param \Symplify\Skipper\Matcher\FileInfoMatcher $fileInfoMatcher
     */
    public function __construct($skippedMessagesResolver, $fileInfoMatcher)
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
    public function shouldSkip($element, \RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
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
