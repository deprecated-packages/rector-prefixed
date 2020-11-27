<?php

namespace _PhpScoper26e51eeacccf\React\Http\Client;

use _PhpScoper26e51eeacccf\React\EventLoop\LoopInterface;
use _PhpScoper26e51eeacccf\React\Socket\ConnectorInterface;
use _PhpScoper26e51eeacccf\React\Socket\Connector;
/**
 * @internal
 */
class Client
{
    private $connector;
    public function __construct(\_PhpScoper26e51eeacccf\React\EventLoop\LoopInterface $loop, \_PhpScoper26e51eeacccf\React\Socket\ConnectorInterface $connector = null)
    {
        if ($connector === null) {
            $connector = new \_PhpScoper26e51eeacccf\React\Socket\Connector($loop);
        }
        $this->connector = $connector;
    }
    public function request($method, $url, array $headers = array(), $protocolVersion = '1.0')
    {
        $requestData = new \_PhpScoper26e51eeacccf\React\Http\Client\RequestData($method, $url, $headers, $protocolVersion);
        return new \_PhpScoper26e51eeacccf\React\Http\Client\Request($this->connector, $requestData);
    }
}
