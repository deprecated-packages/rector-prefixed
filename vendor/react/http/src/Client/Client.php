<?php

namespace _PhpScoperbd5d0c5f7638\React\Http\Client;

use _PhpScoperbd5d0c5f7638\React\EventLoop\LoopInterface;
use _PhpScoperbd5d0c5f7638\React\Socket\ConnectorInterface;
use _PhpScoperbd5d0c5f7638\React\Socket\Connector;
/**
 * @internal
 */
class Client
{
    private $connector;
    public function __construct(\_PhpScoperbd5d0c5f7638\React\EventLoop\LoopInterface $loop, \_PhpScoperbd5d0c5f7638\React\Socket\ConnectorInterface $connector = null)
    {
        if ($connector === null) {
            $connector = new \_PhpScoperbd5d0c5f7638\React\Socket\Connector($loop);
        }
        $this->connector = $connector;
    }
    public function request($method, $url, array $headers = array(), $protocolVersion = '1.0')
    {
        $requestData = new \_PhpScoperbd5d0c5f7638\React\Http\Client\RequestData($method, $url, $headers, $protocolVersion);
        return new \_PhpScoperbd5d0c5f7638\React\Http\Client\Request($this->connector, $requestData);
    }
}
