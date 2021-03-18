<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210318\Symfony\Component\HttpFoundation\Session\Flash;

/**
 * AutoExpireFlashBag flash message container.
 *
 * @author Drak <drak@zikula.org>
 */
class AutoExpireFlashBag implements \RectorPrefix20210318\Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface
{
    private $name = 'flashes';
    private $flashes = ['display' => [], 'new' => []];
    private $storageKey;
    /**
     * @param string $storageKey The key used to store flashes in the session
     */
    public function __construct(string $storageKey = '_symfony_flashes')
    {
        $this->storageKey = $storageKey;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $flashes
     */
    public function initialize(&$flashes)
    {
        $this->flashes =& $flashes;
        // The logic: messages from the last request will be stored in new, so we move them to previous
        // This request we will show what is in 'display'.  What is placed into 'new' this time round will
        // be moved to display next time round.
        $this->flashes['display'] = \array_key_exists('new', $this->flashes) ? $this->flashes['new'] : [];
        $this->flashes['new'] = [];
    }
    /**
     * {@inheritdoc}
     * @param string $type
     */
    public function add($type, $message)
    {
        $this->flashes['new'][$type][] = $message;
    }
    /**
     * {@inheritdoc}
     * @param string $type
     * @param mixed[] $default
     */
    public function peek($type, $default = [])
    {
        return $this->has($type) ? $this->flashes['display'][$type] : $default;
    }
    /**
     * {@inheritdoc}
     */
    public function peekAll()
    {
        return \array_key_exists('display', $this->flashes) ? (array) $this->flashes['display'] : [];
    }
    /**
     * {@inheritdoc}
     * @param string $type
     * @param mixed[] $default
     */
    public function get($type, $default = [])
    {
        $return = $default;
        if (!$this->has($type)) {
            return $return;
        }
        if (isset($this->flashes['display'][$type])) {
            $return = $this->flashes['display'][$type];
            unset($this->flashes['display'][$type]);
        }
        return $return;
    }
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        $return = $this->flashes['display'];
        $this->flashes['display'] = [];
        return $return;
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $messages
     */
    public function setAll($messages)
    {
        $this->flashes['new'] = $messages;
    }
    /**
     * {@inheritdoc}
     * @param string $type
     */
    public function set($type, $messages)
    {
        $this->flashes['new'][$type] = (array) $messages;
    }
    /**
     * {@inheritdoc}
     * @param string $type
     */
    public function has($type)
    {
        return \array_key_exists($type, $this->flashes['display']) && $this->flashes['display'][$type];
    }
    /**
     * {@inheritdoc}
     */
    public function keys()
    {
        return \array_keys($this->flashes['display']);
    }
    /**
     * {@inheritdoc}
     */
    public function getStorageKey()
    {
        return $this->storageKey;
    }
    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        return $this->all();
    }
}
