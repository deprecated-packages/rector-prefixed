<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio;

use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class SensioRouteTagValueNode extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    public function getShortName() : string
    {
        return '@Route';
    }
    public function getSilentKey() : string
    {
        return 'path';
    }
    public function removeService() : void
    {
        unset($this->items['service']);
    }
}
