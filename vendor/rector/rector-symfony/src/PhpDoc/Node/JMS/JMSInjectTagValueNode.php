<?php

declare (strict_types=1);
namespace Rector\Symfony\PhpDoc\Node\JMS;

use Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
/**
 * @see https://jmsyst.com/bundles/JMSDiExtraBundle/master/annotations#inject
 */
final class JMSInjectTagValueNode extends \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    /**
     * @var string|null
     */
    private $serviceName;
    public function __construct(\Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter, \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter, array $items, ?string $serviceName, ?string $annotationContent)
    {
        $this->serviceName = $serviceName;
        parent::__construct($arrayPartPhpDocTagPrinter, $tagValueNodePrinter, $items, $annotationContent);
    }
    public function getServiceName() : ?string
    {
        return $this->serviceName;
    }
    public function getShortName() : string
    {
        return '@DI\\Inject';
    }
    public function getSilentKey() : string
    {
        return 'value';
    }
}
