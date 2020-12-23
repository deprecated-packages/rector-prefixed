<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\Skipper\Contract;

use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
interface SkipVoterInterface
{
    /**
     * @param string|object $element
     */
    public function match($element) : bool;
    /**
     * @param string|object $element
     */
    public function shouldSkip($element, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool;
}
