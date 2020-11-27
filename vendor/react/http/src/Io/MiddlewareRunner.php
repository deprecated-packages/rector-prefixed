<?php

namespace _PhpScoper88fe6e0ad041\React\Http\Io;

use _PhpScoper88fe6e0ad041\Psr\Http\Message\ResponseInterface;
use _PhpScoper88fe6e0ad041\Psr\Http\Message\ServerRequestInterface;
use _PhpScoper88fe6e0ad041\React\Promise\PromiseInterface;
/**
 * [Internal] Middleware runner to expose an array of middleware request handlers as a single request handler callable
 *
 * @internal
 */
final class MiddlewareRunner
{
    /**
     * @var callable[]
     */
    private $middleware;
    /**
     * @param callable[] $middleware
     */
    public function __construct(array $middleware)
    {
        $this->middleware = \array_values($middleware);
    }
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface|PromiseInterface<ResponseInterface>
     * @throws \Exception
     */
    public function __invoke(\_PhpScoper88fe6e0ad041\Psr\Http\Message\ServerRequestInterface $request)
    {
        if (empty($this->middleware)) {
            throw new \RuntimeException('No middleware to run');
        }
        return $this->call($request, 0);
    }
    /** @internal */
    public function call(\_PhpScoper88fe6e0ad041\Psr\Http\Message\ServerRequestInterface $request, $position)
    {
        // final request handler will be invoked without a next handler
        if (!isset($this->middleware[$position + 1])) {
            $handler = $this->middleware[$position];
            return $handler($request);
        }
        $that = $this;
        $next = function (\_PhpScoper88fe6e0ad041\Psr\Http\Message\ServerRequestInterface $request) use($that, $position) {
            return $that->call($request, $position + 1);
        };
        // invoke middleware request handler with next handler
        $handler = $this->middleware[$position];
        return $handler($request, $next);
    }
}
