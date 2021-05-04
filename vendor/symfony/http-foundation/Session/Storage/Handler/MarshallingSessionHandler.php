<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210504\Symfony\Component\HttpFoundation\Session\Storage\Handler;

use RectorPrefix20210504\Symfony\Component\Cache\Marshaller\MarshallerInterface;
/**
 * @author Ahmed TAILOULOUTE <ahmed.tailouloute@gmail.com>
 */
class MarshallingSessionHandler implements \SessionHandlerInterface, \SessionUpdateTimestampHandlerInterface
{
    private $handler;
    private $marshaller;
    public function __construct(\RectorPrefix20210504\Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler $handler, \RectorPrefix20210504\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller)
    {
        $this->handler = $handler;
        $this->marshaller = $marshaller;
    }
    /**
     * @return bool
     */
    public function open($savePath, $name)
    {
        return $this->handler->open($savePath, $name);
    }
    /**
     * @return bool
     */
    public function close()
    {
        return $this->handler->close();
    }
    /**
     * @return bool
     */
    public function destroy($sessionId)
    {
        return $this->handler->destroy($sessionId);
    }
    /**
     * @return bool
     */
    public function gc($maxlifetime)
    {
        return $this->handler->gc($maxlifetime);
    }
    /**
     * @return string
     */
    public function read($sessionId)
    {
        return $this->marshaller->unmarshall($this->handler->read($sessionId));
    }
    /**
     * @return bool
     */
    public function write($sessionId, $data)
    {
        $failed = [];
        $marshalledData = $this->marshaller->marshall(['data' => $data], $failed);
        if (isset($failed['data'])) {
            return \false;
        }
        return $this->handler->write($sessionId, $marshalledData['data']);
    }
    /**
     * @return bool
     */
    public function validateId($sessionId)
    {
        return $this->handler->validateId($sessionId);
    }
    /**
     * @return bool
     */
    public function updateTimestamp($sessionId, $data)
    {
        return $this->handler->updateTimestamp($sessionId, $data);
    }
}
