<?php

declare (strict_types=1);
namespace Rector\DependencyInjection\TypeAnalyzer;

use RectorPrefix20210318\Nette\Utils\Strings;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode;
final class InjectParameterAnalyzer
{
    /**
     * @var string
     * @see https://regex101.com/r/pjusUN/1
     */
    private const BETWEEN_PERCENT_CHARS_REGEX = '#%(.*?)%#';
    public function isParameterInject(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : bool
    {
        if (!$phpDocTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode) {
            return \false;
        }
        $serviceName = $phpDocTagValueNode->getServiceName();
        if ($serviceName === null) {
            return \false;
        }
        return (bool) \RectorPrefix20210318\Nette\Utils\Strings::match($serviceName, self::BETWEEN_PERCENT_CHARS_REGEX);
    }
}
