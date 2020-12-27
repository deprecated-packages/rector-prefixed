<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PHPStan\DependencyInjection\Container;
class LazyReadWritePropertiesExtensionProvider implements \PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider
{
    /** @var Container */
    private $container;
    /** @var ReadWritePropertiesExtension[]|null */
    private $extensions = null;
    public function __construct(\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getExtensions() : array
    {
        if ($this->extensions === null) {
            $this->extensions = $this->container->getServicesByTag(\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider::EXTENSION_TAG);
        }
        return $this->extensions;
    }
}
