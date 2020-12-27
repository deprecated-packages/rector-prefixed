<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Properties;

use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
class LazyReadWritePropertiesExtensionProvider implements \RectorPrefix20201227\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider
{
    /** @var Container */
    private $container;
    /** @var ReadWritePropertiesExtension[]|null */
    private $extensions = null;
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getExtensions() : array
    {
        if ($this->extensions === null) {
            $this->extensions = $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider::EXTENSION_TAG);
        }
        return $this->extensions;
    }
}
