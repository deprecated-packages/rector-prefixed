<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Properties;

use _PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Container;
class LazyReadWritePropertiesExtensionProvider implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider
{
    /** @var Container */
    private $container;
    /** @var ReadWritePropertiesExtension[]|null */
    private $extensions = null;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getExtensions() : array
    {
        if ($this->extensions === null) {
            $this->extensions = $this->container->getServicesByTag(\_PhpScoper0a6b37af0871\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider::EXTENSION_TAG);
        }
        return $this->extensions;
    }
}
