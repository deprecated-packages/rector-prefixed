<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210423\Symfony\Component\Console\CommandLoader;

use RectorPrefix20210423\Symfony\Component\Console\Command\Command;
use RectorPrefix20210423\Symfony\Component\Console\Exception\CommandNotFoundException;
/**
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
interface CommandLoaderInterface
{
    /**
     * Loads a command.
     *
     * @return Command
     *
     * @throws CommandNotFoundException
     * @param string $name
     */
    public function get($name);
    /**
     * Checks if a command exists.
     *
     * @return bool
     * @param string $name
     */
    public function has($name);
    /**
     * @return string[] All registered command names
     */
    public function getNames();
}
