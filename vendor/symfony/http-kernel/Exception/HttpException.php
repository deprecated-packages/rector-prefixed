<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210317\Symfony\Component\HttpKernel\Exception;

/**
 * HttpException.
 *
 * @author Kris Wallsmith <kris@symfony.com>
 */
class HttpException extends \RuntimeException implements \RectorPrefix20210317\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface
{
    private $statusCode;
    private $headers;
    /**
     * @param int $statusCode
     * @param string|null $message
     * @param \Throwable $previous
     * @param mixed[] $headers
     * @param int|null $code
     */
    public function __construct($statusCode, $message = '', $previous = null, $headers = [], $code = 0)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        parent::__construct($message, $code, $previous);
    }
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    public function getHeaders()
    {
        return $this->headers;
    }
    /**
     * Set response headers.
     *
     * @param array $headers Response headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }
}
