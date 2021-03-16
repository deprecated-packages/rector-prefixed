<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception;

/**
 * @author Eriksen Costa <eriksen.costa@infranology.com.br>
 */
class MethodArgumentNotImplementedException extends \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException
{
    /**
     * @param string $methodName The method name that raised the exception
     * @param string $argName    The argument name that is not implemented
     */
    public function __construct(string $methodName, string $argName)
    {
        $message = \sprintf('The %s() method\'s argument $%s behavior is not implemented.', $methodName, $argName);
        parent::__construct($message);
    }
}
