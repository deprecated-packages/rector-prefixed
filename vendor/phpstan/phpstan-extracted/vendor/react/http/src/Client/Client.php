<?php

namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Http\Client;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\EventLoop\LoopInterface;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Socket\ConnectorInterface;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Socket\Connector;
/**
 * @internal
 */
class Client
{
    private $connector;
    public function __construct(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\EventLoop\LoopInterface $loop, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Socket\ConnectorInterface $connector = null)
    {
        if ($connector === null) {
            $connector = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Socket\Connector($loop);
        }
        $this->connector = $connector;
    }
    public function request($method, $url, array $headers = array(), $protocolVersion = '1.0')
    {
        $requestData = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Http\Client\RequestData($method, $url, $headers, $protocolVersion);
        return new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Http\Client\Request($this->connector, $requestData);
    }
}
