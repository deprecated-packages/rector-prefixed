<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS;

use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class JMSInjectTagValueNode extends \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    /**
     * @var string|null
     */
    private $serviceName;
    public function __construct(array $items, ?string $serviceName, ?string $annotationContent)
    {
        $this->serviceName = $serviceName;
        parent::__construct($items, $annotationContent);
    }
    public function getServiceName() : ?string
    {
        return $this->serviceName;
    }
    public function getShortName() : string
    {
        return '_PhpScoper0a2ac50786fa\\@DI\\Inject';
    }
    public function getSilentKey() : string
    {
        return 'value';
    }
}
