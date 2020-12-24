<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Contract;

use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
interface SkipVoterInterface
{
    /**
     * @param string|object $element
     */
    public function match($element) : bool;
    /**
     * @param string|object $element
     */
    public function shouldSkip($element, \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool;
}
