<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ValueObject;

use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName;
final class ObjectMagicMethods
{
    /**
     * @var string[]
     */
    public const METHOD_NAMES = ['__call', '__callStatic', '__clone', \_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT, '__debugInfo', \_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::DESCTRUCT, '__get', '__invoke', '__isset', '__serialize', '__set', \_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::SET_STATE, '__sleep', '__toString', '__unserialize', '__unset', '__wakeup'];
}
