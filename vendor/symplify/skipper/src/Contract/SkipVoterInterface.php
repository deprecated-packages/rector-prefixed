<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\Skipper\Contract;

use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
interface SkipVoterInterface
{
    /**
     * @param string|object $element
     */
    public function match($element) : bool;
    /**
     * @param string|object $element
     */
    public function shouldSkip($element, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool;
}
