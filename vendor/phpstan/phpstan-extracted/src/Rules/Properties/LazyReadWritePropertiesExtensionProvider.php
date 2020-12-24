<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Properties;

use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Container;
class LazyReadWritePropertiesExtensionProvider implements \_PhpScopere8e811afab72\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider
{
    /** @var Container */
    private $container;
    /** @var ReadWritePropertiesExtension[]|null */
    private $extensions = null;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getExtensions() : array
    {
        if ($this->extensions === null) {
            $this->extensions = $this->container->getServicesByTag(\_PhpScopere8e811afab72\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider::EXTENSION_TAG);
        }
        return $this->extensions;
    }
}
