<?php

declare (strict_types=1);
namespace RectorPrefix20210504\App;

use RectorPrefix20210504\Http\Client\Common\Plugin;
use RectorPrefix20210504\Http\Promise\Promise;
use RectorPrefix20210504\Psr\Http\Message\RequestInterface;
class RequestCounterPlugin implements \RectorPrefix20210504\Http\Client\Common\Plugin
{
    private int $totalCount = 0;
    public function handleRequest(\RectorPrefix20210504\Psr\Http\Message\RequestInterface $request, callable $next, callable $first) : \RectorPrefix20210504\Http\Promise\Promise
    {
        $path = $request->getUri()->getPath();
        if ($path === '/rate_limit') {
            return $next($request);
        }
        $this->totalCount++;
        return $next($request);
    }
    public function getTotalCount() : int
    {
        return $this->totalCount;
    }
}
