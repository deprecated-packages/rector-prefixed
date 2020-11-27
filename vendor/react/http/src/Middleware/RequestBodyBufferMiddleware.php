<?php

namespace _PhpScoper88fe6e0ad041\React\Http\Middleware;

use OverflowException;
use _PhpScoper88fe6e0ad041\Psr\Http\Message\ServerRequestInterface;
use _PhpScoper88fe6e0ad041\React\Http\Io\IniUtil;
use _PhpScoper88fe6e0ad041\React\Promise\Stream;
use _PhpScoper88fe6e0ad041\React\Stream\ReadableStreamInterface;
use _PhpScoper88fe6e0ad041\RingCentral\Psr7\BufferStream;
final class RequestBodyBufferMiddleware
{
    private $sizeLimit;
    /**
     * @param int|string|null $sizeLimit Either an int with the max request body size
     *                                   in bytes or an ini like size string
     *                                   or null to use post_max_size from PHP's
     *                                   configuration. (Note that the value from
     *                                   the CLI configuration will be used.)
     */
    public function __construct($sizeLimit = null)
    {
        if ($sizeLimit === null) {
            $sizeLimit = \ini_get('post_max_size');
        }
        $this->sizeLimit = \_PhpScoper88fe6e0ad041\React\Http\Io\IniUtil::iniSizeToBytes($sizeLimit);
    }
    public function __invoke(\_PhpScoper88fe6e0ad041\Psr\Http\Message\ServerRequestInterface $request, $stack)
    {
        $body = $request->getBody();
        $size = $body->getSize();
        // happy path: skip if body is known to be empty (or is already buffered)
        if ($size === 0 || !$body instanceof \_PhpScoper88fe6e0ad041\React\Stream\ReadableStreamInterface) {
            // replace with empty body if body is streaming (or buffered size exceeds limit)
            if ($body instanceof \_PhpScoper88fe6e0ad041\React\Stream\ReadableStreamInterface || $size > $this->sizeLimit) {
                $request = $request->withBody(new \_PhpScoper88fe6e0ad041\RingCentral\Psr7\BufferStream(0));
            }
            return $stack($request);
        }
        // request body of known size exceeding limit
        $sizeLimit = $this->sizeLimit;
        if ($size > $this->sizeLimit) {
            $sizeLimit = 0;
        }
        return \_PhpScoper88fe6e0ad041\React\Promise\Stream\buffer($body, $sizeLimit)->then(function ($buffer) use($request, $stack) {
            $stream = new \_PhpScoper88fe6e0ad041\RingCentral\Psr7\BufferStream(\strlen($buffer));
            $stream->write($buffer);
            $request = $request->withBody($stream);
            return $stack($request);
        }, function ($error) use($stack, $request, $body) {
            // On buffer overflow keep the request body stream in,
            // but ignore the contents and wait for the close event
            // before passing the request on to the next middleware.
            if ($error instanceof \OverflowException) {
                return \_PhpScoper88fe6e0ad041\React\Promise\Stream\first($body, 'close')->then(function () use($stack, $request) {
                    return $stack($request);
                });
            }
            throw $error;
        });
    }
}
