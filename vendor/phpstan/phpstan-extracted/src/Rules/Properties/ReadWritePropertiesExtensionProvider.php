<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Properties;

interface ReadWritePropertiesExtensionProvider
{
    public const EXTENSION_TAG = 'phpstan.properties.readWriteExtension';
    /**
     * @return ReadWritePropertiesExtension[]
     */
    public function getExtensions() : array;
}
