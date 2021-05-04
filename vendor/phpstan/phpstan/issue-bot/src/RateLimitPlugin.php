<?php

declare (strict_types=1);
namespace RectorPrefix20210504\App;

use RectorPrefix20210504\Github\Api\RateLimit;
use RectorPrefix20210504\Github\Api\RateLimit\RateLimitResource;
use RectorPrefix20210504\Github\Client;
use RectorPrefix20210504\Http\Client\Common\Plugin;
use RectorPrefix20210504\Http\Promise\Promise;
use RectorPrefix20210504\Psr\Http\Message\RequestInterface;
class RateLimitPlugin implements \RectorPrefix20210504\Http\Client\Common\Plugin
{
    private \RectorPrefix20210504\Github\Client $client;
    public function setClient(\RectorPrefix20210504\Github\Client $client) : void
    {
        $this->client = $client;
    }
    public function handleRequest(\RectorPrefix20210504\Psr\Http\Message\RequestInterface $request, callable $next, callable $first) : \RectorPrefix20210504\Http\Promise\Promise
    {
        $path = $request->getUri()->getPath();
        if ($path === '/rate_limit') {
            return $next($request);
        }
        /** @var RateLimit $api */
        $api = $this->client->api('rate_limit');
        /** @var RateLimitResource $resource */
        $resource = $api->getResource('core');
        if ($resource->getRemaining() < 10) {
            $reset = $resource->getReset();
            $sleepFor = $reset - \time();
            if ($sleepFor > 0) {
                echo \sprintf("Rate limit exceeded - sleeping for %d seconds\n", $sleepFor);
                \sleep($sleepFor);
            }
        }
        return $next($request);
    }
}
