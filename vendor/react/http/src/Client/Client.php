<?php

namespace _PhpScoper006a73f0e455\React\Http\Client;

use _PhpScoper006a73f0e455\React\EventLoop\LoopInterface;
use _PhpScoper006a73f0e455\React\Socket\ConnectorInterface;
use _PhpScoper006a73f0e455\React\Socket\Connector;
/**
 * @internal
 */
class Client
{
    private $connector;
    public function __construct(\_PhpScoper006a73f0e455\React\EventLoop\LoopInterface $loop, \_PhpScoper006a73f0e455\React\Socket\ConnectorInterface $connector = null)
    {
        if ($connector === null) {
            $connector = new \_PhpScoper006a73f0e455\React\Socket\Connector($loop);
        }
        $this->connector = $connector;
    }
    public function request($method, $url, array $headers = array(), $protocolVersion = '1.0')
    {
        $requestData = new \_PhpScoper006a73f0e455\React\Http\Client\RequestData($method, $url, $headers, $protocolVersion);
        return new \_PhpScoper006a73f0e455\React\Http\Client\Request($this->connector, $requestData);
    }
}
