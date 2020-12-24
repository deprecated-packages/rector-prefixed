<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;

use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
class LazyReflectionProviderProvider implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    /** @var Container */
    private $container;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getReflectionProvider() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider::class);
    }
}
