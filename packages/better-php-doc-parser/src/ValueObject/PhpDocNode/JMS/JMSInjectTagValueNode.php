<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS;

use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class JMSInjectTagValueNode extends \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
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
        return '_PhpScoperb75b35f52b74\\@DI\\Inject';
    }
    public function getSilentKey() : string
    {
        return 'value';
    }
}
