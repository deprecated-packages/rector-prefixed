<?php

declare (strict_types=1);
namespace RectorPrefix20210207\Symplify\Skipper\Contract;

use RectorPrefix20210207\Symplify\SmartFileSystem\SmartFileInfo;
interface SkipVoterInterface
{
    /**
     * @param string|object $element
     */
    public function match($element) : bool;
    /**
     * @param string|object $element
     */
    public function shouldSkip($element, \RectorPrefix20210207\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool;
}
