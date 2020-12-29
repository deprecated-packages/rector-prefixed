<?php

declare (strict_types=1);
namespace RectorPrefix20201229\Symplify\PackageBuilder\Parameter;

use RectorPrefix20201229\Symfony\Component\DependencyInjection\Container;
use RectorPrefix20201229\Symfony\Component\DependencyInjection\ContainerInterface;
use RectorPrefix20201229\Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
/**
 * @see \Symplify\PackageBuilder\Tests\Parameter\ParameterProviderTest
 */
final class ParameterProvider
{
    /**
     * @var array<string, mixed>
     */
    private $parameters = [];
    /**
     * @param Container|ContainerInterface $container
     */
    public function __construct(\RectorPrefix20201229\Symfony\Component\DependencyInjection\ContainerInterface $container)
    {
        $parameterBag = $container->getParameterBag();
        $this->parameters = $parameterBag->all();
    }
    /**
     * @return mixed|null
     */
    public function provideParameter(string $name)
    {
        return $this->parameters[$name] ?? null;
    }
    public function provideStringParameter(string $name) : string
    {
        $this->ensureParameterIsSet($name);
        return (string) $this->parameters[$name];
    }
    public function provideIntParameter(string $name) : int
    {
        $this->ensureParameterIsSet($name);
        return (int) $this->parameters[$name];
    }
    /**
     * @return mixed[]
     */
    public function provideArrayParameter(string $name) : array
    {
        $this->ensureParameterIsSet($name);
        return $this->parameters[$name];
    }
    public function provideBoolParameter(string $parameterName) : bool
    {
        return $this->parameters[$parameterName] ?? \false;
    }
    public function changeParameter(string $name, $value) : void
    {
        $this->parameters[$name] = $value;
    }
    /**
     * @return mixed[]
     */
    public function provide() : array
    {
        return $this->parameters;
    }
    private function ensureParameterIsSet(string $name) : void
    {
        if (\array_key_exists($name, $this->parameters)) {
            return;
        }
        throw new \RectorPrefix20201229\Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException($name);
    }
}
