<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper50d83356d739\Symfony\Component\HttpKernel\DependencyInjection;

use _PhpScoper50d83356d739\Symfony\Component\DependencyInjection\Compiler\MergeExtensionConfigurationPass as BaseMergeExtensionConfigurationPass;
use _PhpScoper50d83356d739\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * Ensures certain extensions are always loaded.
 *
 * @author Kris Wallsmith <kris@symfony.com>
 */
class MergeExtensionConfigurationPass extends \_PhpScoper50d83356d739\Symfony\Component\DependencyInjection\Compiler\MergeExtensionConfigurationPass
{
    private $extensions;
    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
    }
    public function process(\_PhpScoper50d83356d739\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        foreach ($this->extensions as $extension) {
            if (!\count($container->getExtensionConfig($extension))) {
                $container->loadFromExtension($extension, []);
            }
        }
        parent::process($container);
    }
}
