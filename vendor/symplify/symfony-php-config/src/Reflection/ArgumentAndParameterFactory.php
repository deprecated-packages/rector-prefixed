<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\Reflection;

use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
final class ArgumentAndParameterFactory
{
    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;
    public function __construct()
    {
        $this->privatesAccessor = new \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\PrivatesAccessor();
    }
    /**
     * @param array<string, mixed> $arguments
     * @param array<string, mixed> $properties
     */
    public function create(string $className, array $arguments, array $properties) : object
    {
        $object = new $className(...$arguments);
        foreach ($properties as $name => $value) {
            $this->privatesAccessor->setPrivateProperty($object, $name, $value);
        }
        return $object;
    }
}
