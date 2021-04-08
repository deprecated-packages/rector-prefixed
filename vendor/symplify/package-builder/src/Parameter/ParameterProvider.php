<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Symplify\PackageBuilder\Parameter;

use RectorPrefix20210408\Symfony\Component\DependencyInjection\Container;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerInterface;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
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
    public function __construct(\RectorPrefix20210408\Symfony\Component\DependencyInjection\ContainerInterface $container)
    {
        $parameterBag = $container->getParameterBag();
        $this->parameters = $parameterBag->all();
    }
    /**
     * @api
     * @return mixed|null
     */
    public function provideParameter(string $name)
    {
        return $this->parameters[$name] ?? null;
    }
    /**
     * @api
     */
    public function provideStringParameter(string $name) : string
    {
        $this->ensureParameterIsSet($name);
        return (string) $this->parameters[$name];
    }
    /**
     * @api
     * @return mixed[]
     */
    public function provideArrayParameter(string $name) : array
    {
        $this->ensureParameterIsSet($name);
        return $this->parameters[$name];
    }
    /**
     * @api
     */
    public function provideBoolParameter(string $parameterName) : bool
    {
        return $this->parameters[$parameterName] ?? \false;
    }
    public function changeParameter(string $name, $value) : void
    {
        $this->parameters[$name] = $value;
    }
    /**
     * @api
     * @return mixed[]
     */
    public function provide() : array
    {
        return $this->parameters;
    }
    /**
     * @api
     */
    public function provideIntParameter(string $name) : int
    {
        $this->ensureParameterIsSet($name);
        return (int) $this->parameters[$name];
    }
    /**
     * @api
     */
    public function ensureParameterIsSet(string $name) : void
    {
        if (\array_key_exists($name, $this->parameters)) {
            return;
        }
        throw new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException($name);
    }
}
