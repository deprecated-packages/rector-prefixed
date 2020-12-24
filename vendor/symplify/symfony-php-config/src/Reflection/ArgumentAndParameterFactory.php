<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\Reflection;

use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
final class ArgumentAndParameterFactory
{
    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;
    public function __construct()
    {
        $this->privatesAccessor = new \_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor();
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
