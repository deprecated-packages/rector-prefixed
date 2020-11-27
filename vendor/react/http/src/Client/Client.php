<?php

namespace _PhpScoper88fe6e0ad041\React\Http\Client;

use _PhpScoper88fe6e0ad041\React\EventLoop\LoopInterface;
use _PhpScoper88fe6e0ad041\React\Socket\ConnectorInterface;
use _PhpScoper88fe6e0ad041\React\Socket\Connector;
/**
 * @internal
 */
class Client
{
    private $connector;
    public function __construct(\_PhpScoper88fe6e0ad041\React\EventLoop\LoopInterface $loop, \_PhpScoper88fe6e0ad041\React\Socket\ConnectorInterface $connector = null)
    {
        if ($connector === null) {
            $connector = new \_PhpScoper88fe6e0ad041\React\Socket\Connector($loop);
        }
        $this->connector = $connector;
    }
    public function request($method, $url, array $headers = array(), $protocolVersion = '1.0')
    {
        $requestData = new \_PhpScoper88fe6e0ad041\React\Http\Client\RequestData($method, $url, $headers, $protocolVersion);
        return new \_PhpScoper88fe6e0ad041\React\Http\Client\Request($this->connector, $requestData);
    }
}
