<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210423\Symfony\Component\HttpKernel\CacheClearer;

/**
 * ChainCacheClearer.
 *
 * @author Dustin Dobervich <ddobervich@gmail.com>
 *
 * @final
 */
class ChainCacheClearer implements \RectorPrefix20210423\Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface
{
    private $clearers;
    /**
     * @param mixed[] $clearers
     */
    public function __construct($clearers = [])
    {
        $this->clearers = $clearers;
    }
    /**
     * {@inheritdoc}
     * @param string $cacheDir
     */
    public function clear($cacheDir)
    {
        foreach ($this->clearers as $clearer) {
            $clearer->clear($cacheDir);
        }
    }
}
