<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Compiler;

use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * Interface that must be implemented by compilation passes.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
interface CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\ContainerBuilder $container);
}
