<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject;

use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
final class ObjectMagicMethods
{
    /**
     * @var string[]
     */
    public const METHOD_NAMES = ['__call', '__callStatic', '__clone', \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT, '__debugInfo', \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::DESCTRUCT, '__get', '__invoke', '__isset', '__serialize', '__set', \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::SET_STATE, '__sleep', '__toString', '__unserialize', '__unset', '__wakeup'];
}
