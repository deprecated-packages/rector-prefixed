<?php

namespace _PhpScopera143bcca66cb\React\Socket;

use _PhpScopera143bcca66cb\Evenement\EventEmitter;
use _PhpScopera143bcca66cb\React\EventLoop\LoopInterface;
use Exception;
final class Server extends \_PhpScopera143bcca66cb\Evenement\EventEmitter implements \_PhpScopera143bcca66cb\React\Socket\ServerInterface
{
    private $server;
    public function __construct($uri, \_PhpScopera143bcca66cb\React\EventLoop\LoopInterface $loop, array $context = array())
    {
        // sanitize TCP context options if not properly wrapped
        if ($context && (!isset($context['tcp']) && !isset($context['tls']) && !isset($context['unix']))) {
            $context = array('tcp' => $context);
        }
        // apply default options if not explicitly given
        $context += array('tcp' => array(), 'tls' => array(), 'unix' => array());
        $scheme = 'tcp';
        $pos = \strpos($uri, '://');
        if ($pos !== \false) {
            $scheme = \substr($uri, 0, $pos);
        }
        if ($scheme === 'unix') {
            $server = new \_PhpScopera143bcca66cb\React\Socket\UnixServer($uri, $loop, $context['unix']);
        } else {
            $server = new \_PhpScopera143bcca66cb\React\Socket\TcpServer(\str_replace('tls://', '', $uri), $loop, $context['tcp']);
            if ($scheme === 'tls') {
                $server = new \_PhpScopera143bcca66cb\React\Socket\SecureServer($server, $loop, $context['tls']);
            }
        }
        $this->server = $server;
        $that = $this;
        $server->on('connection', function (\_PhpScopera143bcca66cb\React\Socket\ConnectionInterface $conn) use($that) {
            $that->emit('connection', array($conn));
        });
        $server->on('error', function (\Exception $error) use($that) {
            $that->emit('error', array($error));
        });
    }
    public function getAddress()
    {
        return $this->server->getAddress();
    }
    public function pause()
    {
        $this->server->pause();
    }
    public function resume()
    {
        $this->server->resume();
    }
    public function close()
    {
        $this->server->close();
    }
}
