<?php

namespace _PhpScoperabd03f0baf05\React\Http\Client;

use _PhpScoperabd03f0baf05\React\EventLoop\LoopInterface;
use _PhpScoperabd03f0baf05\React\Socket\ConnectorInterface;
use _PhpScoperabd03f0baf05\React\Socket\Connector;
/**
 * @internal
 */
class Client
{
    private $connector;
    public function __construct(\_PhpScoperabd03f0baf05\React\EventLoop\LoopInterface $loop, \_PhpScoperabd03f0baf05\React\Socket\ConnectorInterface $connector = null)
    {
        if ($connector === null) {
            $connector = new \_PhpScoperabd03f0baf05\React\Socket\Connector($loop);
        }
        $this->connector = $connector;
    }
    public function request($method, $url, array $headers = array(), $protocolVersion = '1.0')
    {
        $requestData = new \_PhpScoperabd03f0baf05\React\Http\Client\RequestData($method, $url, $headers, $protocolVersion);
        return new \_PhpScoperabd03f0baf05\React\Http\Client\Request($this->connector, $requestData);
    }
}
