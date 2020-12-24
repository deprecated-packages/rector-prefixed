<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\Skipper\Skipper;

use _PhpScopere8e811afab72\Symplify\Skipper\Contract\SkipVoterInterface;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\Skipper\Tests\Skipper\Skipper\SkipperTest
 */
final class Skipper
{
    /**
     * @var string
     */
    private const FILE_ELEMENT = 'file_elements';
    /**
     * @var SkipVoterInterface[]
     */
    private $skipVoters = [];
    /**
     * @param SkipVoterInterface[] $skipVoters
     */
    public function __construct(array $skipVoters)
    {
        $this->skipVoters = $skipVoters;
    }
    /**
     * @param string|object $element
     */
    public function shouldSkipElement($element) : bool
    {
        $fileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__FILE__);
        return $this->shouldSkipElementAndFileInfo($element, $fileInfo);
    }
    public function shouldSkipFileInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        return $this->shouldSkipElementAndFileInfo(self::FILE_ELEMENT, $smartFileInfo);
    }
    /**
     * @param string|object $element
     */
    public function shouldSkipElementAndFileInfo($element, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        foreach ($this->skipVoters as $skipVoter) {
            if ($skipVoter->match($element)) {
                return $skipVoter->shouldSkip($element, $smartFileInfo);
            }
        }
        return \false;
    }
}
