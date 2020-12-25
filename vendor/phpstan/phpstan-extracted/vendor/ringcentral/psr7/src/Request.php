<?php

namespace _HumbugBox221ad6f1b81f\RingCentral\Psr7;

use InvalidArgumentException;
use _HumbugBox221ad6f1b81f\Psr\Http\Message\RequestInterface;
use _HumbugBox221ad6f1b81f\Psr\Http\Message\StreamInterface;
use _HumbugBox221ad6f1b81f\Psr\Http\Message\UriInterface;
/**
 * PSR-7 request implementation.
 */
class Request extends \_HumbugBox221ad6f1b81f\RingCentral\Psr7\MessageTrait implements \_HumbugBox221ad6f1b81f\Psr\Http\Message\RequestInterface
{
    /** @var string */
    private $method;
    /** @var null|string */
    private $requestTarget;
    /** @var null|UriInterface */
    private $uri;
    /**
     * @param null|string $method HTTP method for the request.
     * @param null|string|UriInterface $uri URI for the request.
     * @param array $headers Headers for the message.
     * @param string|resource|StreamInterface $body Message body.
     * @param string $protocolVersion HTTP protocol version.
     *
     * @throws InvalidArgumentException for an invalid URI
     */
    public function __construct($method, $uri, array $headers = array(), $body = null, $protocolVersion = '1.1')
    {
        if (\is_string($uri)) {
            $uri = new \_HumbugBox221ad6f1b81f\RingCentral\Psr7\Uri($uri);
        } elseif (!$uri instanceof \_HumbugBox221ad6f1b81f\Psr\Http\Message\UriInterface) {
            throw new \InvalidArgumentException('_HumbugBox221ad6f1b81f\\URI must be a string or Psr\\Http\\Message\\UriInterface');
        }
        $this->method = \strtoupper($method);
        $this->uri = $uri;
        $this->setHeaders($headers);
        $this->protocol = $protocolVersion;
        $host = $uri->getHost();
        if ($host && !$this->hasHeader('Host')) {
            $this->updateHostFromUri($host);
        }
        if ($body) {
            $this->stream = stream_for($body);
        }
    }
    public function getRequestTarget()
    {
        if ($this->requestTarget !== null) {
            return $this->requestTarget;
        }
        $target = $this->uri->getPath();
        if ($target == null) {
            $target = '/';
        }
        if ($this->uri->getQuery()) {
            $target .= '?' . $this->uri->getQuery();
        }
        return $target;
    }
    public function withRequestTarget($requestTarget)
    {
        if (\preg_match('#\\s#', $requestTarget)) {
            throw new \InvalidArgumentException('Invalid request target provided; cannot contain whitespace');
        }
        $new = clone $this;
        $new->requestTarget = $requestTarget;
        return $new;
    }
    public function getMethod()
    {
        return $this->method;
    }
    public function withMethod($method)
    {
        $new = clone $this;
        $new->method = \strtoupper($method);
        return $new;
    }
    public function getUri()
    {
        return $this->uri;
    }
    public function withUri(\_HumbugBox221ad6f1b81f\Psr\Http\Message\UriInterface $uri, $preserveHost = \false)
    {
        if ($uri === $this->uri) {
            return $this;
        }
        $new = clone $this;
        $new->uri = $uri;
        if (!$preserveHost) {
            if ($host = $uri->getHost()) {
                $new->updateHostFromUri($host);
            }
        }
        return $new;
    }
    public function withHeader($header, $value)
    {
        /** @var Request $newInstance */
        $newInstance = parent::withHeader($header, $value);
        return $newInstance;
    }
    private function updateHostFromUri($host)
    {
        // Ensure Host is the first header.
        // See: http://tools.ietf.org/html/rfc7230#section-5.4
        if ($port = $this->uri->getPort()) {
            $host .= ':' . $port;
        }
        $this->headerLines = array('Host' => array($host)) + $this->headerLines;
        $this->headers = array('host' => array($host)) + $this->headers;
    }
}
