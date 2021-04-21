<?php

declare(strict_types=1);

namespace Symplify\Skipper\SkipVoter;

use Symplify\Skipper\Contract\SkipVoterInterface;
use Symplify\Skipper\Matcher\FileInfoMatcher;
use Symplify\Skipper\SkipCriteriaResolver\SkippedMessagesResolver;
use Symplify\SmartFileSystem\SmartFileInfo;

final class MessageSkipVoter implements SkipVoterInterface
{
    /**
     * @var SkippedMessagesResolver
     */
    private $skippedMessagesResolver;

    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;

    public function __construct(
        SkippedMessagesResolver $skippedMessagesResolver,
        FileInfoMatcher $fileInfoMatcher
    ) {
        $this->skippedMessagesResolver = $skippedMessagesResolver;
        $this->fileInfoMatcher = $fileInfoMatcher;
    }

    /**
     * @param string|object $element
     */
    public function match($element): bool
    {
        if (is_object($element)) {
            return false;
        }

        return substr_count($element, ' ') > 0;
    }

    /**
     * @param string $element
     */
    public function shouldSkip($element, SmartFileInfo $smartFileInfo): bool
    {
        $skippedMessages = $this->skippedMessagesResolver->resolve();
        if (! array_key_exists($element, $skippedMessages)) {
            return false;
        }

        // skip regardless the path
        $skippedPaths = $skippedMessages[$element];
        if ($skippedPaths === null) {
            return true;
        }

        return $this->fileInfoMatcher->doesFileInfoMatchPatterns($smartFileInfo, $skippedPaths);
    }
}
