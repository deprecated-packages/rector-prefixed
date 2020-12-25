<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\Compiler;

use _PhpScoper5b8c9e9ebd21\Symfony\Component\Config\Definition\BaseNode;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\Config\Definition\ConfigurationInterface;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\Config\Definition\Processor;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\Extension\ConfigurationExtensionInterface;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
/**
 * Validates environment variable placeholders used in extension configuration with dummy values.
 *
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class ValidateEnvPlaceholdersPass implements \_PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private static $typeFixtures = ['array' => [], 'bool' => \false, 'float' => 0.0, 'int' => 0, 'string' => ''];
    private $extensionConfig = [];
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $this->extensionConfig = [];
        if (!\class_exists(\_PhpScoper5b8c9e9ebd21\Symfony\Component\Config\Definition\BaseNode::class) || !($extensions = $container->getExtensions())) {
            return;
        }
        $resolvingBag = $container->getParameterBag();
        if (!$resolvingBag instanceof \_PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag) {
            return;
        }
        $defaultBag = new \_PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\ParameterBag\ParameterBag($resolvingBag->all());
        $envTypes = $resolvingBag->getProvidedTypes();
        try {
            foreach ($resolvingBag->getEnvPlaceholders() + $resolvingBag->getUnusedEnvPlaceholders() as $env => $placeholders) {
                $values = [];
                if (\false === ($i = \strpos($env, ':'))) {
                    $default = $defaultBag->has("env({$env})") ? $defaultBag->get("env({$env})") : self::$typeFixtures['string'];
                    $defaultType = null !== $default ? \get_debug_type($default) : 'string';
                    $values[$defaultType] = $default;
                } else {
                    $prefix = \substr($env, 0, $i);
                    foreach ($envTypes[$prefix] ?? ['string'] as $type) {
                        $values[$type] = self::$typeFixtures[$type] ?? null;
                    }
                }
                foreach ($placeholders as $placeholder) {
                    \_PhpScoper5b8c9e9ebd21\Symfony\Component\Config\Definition\BaseNode::setPlaceholder($placeholder, $values);
                }
            }
            $processor = new \_PhpScoper5b8c9e9ebd21\Symfony\Component\Config\Definition\Processor();
            foreach ($extensions as $name => $extension) {
                if (!($extension instanceof \_PhpScoper5b8c9e9ebd21\Symfony\Component\DependencyInjection\Extension\ConfigurationExtensionInterface || $extension instanceof \_PhpScoper5b8c9e9ebd21\Symfony\Component\Config\Definition\ConfigurationInterface) || !($config = \array_filter($container->getExtensionConfig($name)))) {
                    // this extension has no semantic configuration or was not called
                    continue;
                }
                $config = $resolvingBag->resolveValue($config);
                if ($extension instanceof \_PhpScoper5b8c9e9ebd21\Symfony\Component\Config\Definition\ConfigurationInterface) {
                    $configuration = $extension;
                } elseif (null === ($configuration = $extension->getConfiguration($config, $container))) {
                    continue;
                }
                $this->extensionConfig[$name] = $processor->processConfiguration($configuration, $config);
            }
        } finally {
            \_PhpScoper5b8c9e9ebd21\Symfony\Component\Config\Definition\BaseNode::resetPlaceholders();
        }
        $resolvingBag->clearUnusedEnvPlaceholders();
    }
    /**
     * @internal
     */
    public function getExtensionConfig() : array
    {
        try {
            return $this->extensionConfig;
        } finally {
            $this->extensionConfig = [];
        }
    }
}
