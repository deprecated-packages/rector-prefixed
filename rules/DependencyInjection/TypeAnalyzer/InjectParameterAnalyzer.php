<?php

declare (strict_types=1);
namespace Rector\DependencyInjection\TypeAnalyzer;

use RectorPrefix20210331\Nette\Utils\Strings;
use PHPStan\PhpDocParser\Ast\Node;
use Rector\Symfony\PhpDoc\Node\JMS\JMSInjectTagValueNode;
final class InjectParameterAnalyzer
{
    /**
     * @var string
     * @see https://regex101.com/r/pjusUN/1
     */
    private const BETWEEN_PERCENT_CHARS_REGEX = '#%(.*?)%#';
    public function isParameterInject(\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        if (!$node instanceof \Rector\Symfony\PhpDoc\Node\JMS\JMSInjectTagValueNode) {
            return \false;
        }
        $serviceName = $node->getServiceName();
        if ($serviceName === null) {
            return \false;
        }
        return (bool) \RectorPrefix20210331\Nette\Utils\Strings::match($serviceName, self::BETWEEN_PERCENT_CHARS_REGEX);
    }
}
