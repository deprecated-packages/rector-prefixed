<?php

namespace _PhpScopera143bcca66cb\React\Http\Client;

use _PhpScopera143bcca66cb\React\EventLoop\LoopInterface;
use _PhpScopera143bcca66cb\React\Socket\ConnectorInterface;
use _PhpScopera143bcca66cb\React\Socket\Connector;
/**
 * @internal
 */
class Client
{
    private $connector;
    public function __construct(\_PhpScopera143bcca66cb\React\EventLoop\LoopInterface $loop, \_PhpScopera143bcca66cb\React\Socket\ConnectorInterface $connector = null)
    {
        if ($connector === null) {
            $connector = new \_PhpScopera143bcca66cb\React\Socket\Connector($loop);
        }
        $this->connector = $connector;
    }
    public function request($method, $url, array $headers = array(), $protocolVersion = '1.0')
    {
        $requestData = new \_PhpScopera143bcca66cb\React\Http\Client\RequestData($method, $url, $headers, $protocolVersion);
        return new \_PhpScopera143bcca66cb\React\Http\Client\Request($this->connector, $requestData);
    }
}
