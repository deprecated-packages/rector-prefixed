<?php

namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Http\Client;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\EventLoop\LoopInterface;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Socket\ConnectorInterface;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Socket\Connector;
/**
 * @internal
 */
class Client
{
    private $connector;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\EventLoop\LoopInterface $loop, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Socket\ConnectorInterface $connector = null)
    {
        if ($connector === null) {
            $connector = new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Socket\Connector($loop);
        }
        $this->connector = $connector;
    }
    public function request($method, $url, array $headers = array(), $protocolVersion = '1.0')
    {
        $requestData = new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Http\Client\RequestData($method, $url, $headers, $protocolVersion);
        return new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Http\Client\Request($this->connector, $requestData);
    }
}
