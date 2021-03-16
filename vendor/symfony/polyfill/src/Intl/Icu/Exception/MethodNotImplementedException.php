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
class MethodNotImplementedException extends \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException
{
    /**
     * @param string $methodName The name of the method
     */
    public function __construct(string $methodName)
    {
        parent::__construct(\sprintf('The %s() is not implemented.', $methodName));
    }
}
