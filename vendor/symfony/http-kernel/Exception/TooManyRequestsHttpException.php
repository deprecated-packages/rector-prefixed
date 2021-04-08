<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210408\Symfony\Component\HttpKernel\Exception;

/**
 * @author Ben Ramsey <ben@benramsey.com>
 *
 * @see http://tools.ietf.org/html/rfc6585
 */
class TooManyRequestsHttpException extends \RectorPrefix20210408\Symfony\Component\HttpKernel\Exception\HttpException
{
    /**
     * @param int|string|null $retryAfter The number of seconds or HTTP-date after which the request may be retried
     * @param string|null     $message    The internal exception message
     * @param \Throwable|null $previous   The previous exception
     * @param int|null        $code       The internal exception code
     */
    public function __construct($retryAfter = null, ?string $message = '', \Throwable $previous = null, ?int $code = 0, array $headers = [])
    {
        if ($retryAfter) {
            $headers['Retry-After'] = $retryAfter;
        }
        parent::__construct(429, $message, $previous, $headers, $code);
    }
}
