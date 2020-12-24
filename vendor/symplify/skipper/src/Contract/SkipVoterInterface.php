<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\Skipper\Contract;

use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
interface SkipVoterInterface
{
    /**
     * @param string|object $element
     */
    public function match($element) : bool;
    /**
     * @param string|object $element
     */
    public function shouldSkip($element, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool;
}
