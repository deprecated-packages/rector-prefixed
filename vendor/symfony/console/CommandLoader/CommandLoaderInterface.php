<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfce0de0de1ce\Symfony\Component\Console\CommandLoader;

use _PhpScoperfce0de0de1ce\Symfony\Component\Console\Command\Command;
use _PhpScoperfce0de0de1ce\Symfony\Component\Console\Exception\CommandNotFoundException;
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
     */
    public function get(string $name);
    /**
     * Checks if a command exists.
     *
     * @return bool
     */
    public function has(string $name);
    /**
     * @return string[] All registered command names
     */
    public function getNames();
}
