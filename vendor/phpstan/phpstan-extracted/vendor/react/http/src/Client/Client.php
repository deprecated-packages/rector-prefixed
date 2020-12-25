<?php

namespace _HumbugBox221ad6f1b81f\React\Http\Client;

use _HumbugBox221ad6f1b81f\React\EventLoop\LoopInterface;
use _HumbugBox221ad6f1b81f\React\Socket\ConnectorInterface;
use _HumbugBox221ad6f1b81f\React\Socket\Connector;
/**
 * @internal
 */
class Client
{
    private $connector;
    public function __construct(\_HumbugBox221ad6f1b81f\React\EventLoop\LoopInterface $loop, \_HumbugBox221ad6f1b81f\React\Socket\ConnectorInterface $connector = null)
    {
        if ($connector === null) {
            $connector = new \_HumbugBox221ad6f1b81f\React\Socket\Connector($loop);
        }
        $this->connector = $connector;
    }
    public function request($method, $url, array $headers = array(), $protocolVersion = '1.0')
    {
        $requestData = new \_HumbugBox221ad6f1b81f\React\Http\Client\RequestData($method, $url, $headers, $protocolVersion);
        return new \_HumbugBox221ad6f1b81f\React\Http\Client\Request($this->connector, $requestData);
    }
}
