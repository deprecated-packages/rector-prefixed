<?php

declare (strict_types=1);
namespace RectorPrefix20210319\Nette\ComponentModel;

if (\class_exists('RectorPrefix20210319\\Nette\\ComponentModel\\Container')) {
    return;
}
abstract class Container implements \RectorPrefix20210319\Nette\ComponentModel\IContainer
{
    private const NAME_REGEXP = '#^[a-zA-Z0-9_]+$#D';
    /** @var IComponent[] */
    private $components = [];
    /** @var Container|null */
    private $cloning;
    /********************* interface IContainer ****************d*g**/
    /**
     * Adds the component to the container.
     * @return static
     * @throws Nette\InvalidStateException
     * @param string $insertBefore
     */
    public function addComponent(\RectorPrefix20210319\Nette\ComponentModel\IComponent $component, ?string $name, $insertBefore = null)
    {
        if ($name === null) {
            $name = $component->getName();
            if ($name === null) {
                throw new \RectorPrefix20210319\Nette\ComponentModel\Nette\InvalidStateException("Missing component's name.");
            }
        }
        if (!\preg_match(self::NAME_REGEXP, $name)) {
            throw new \RectorPrefix20210319\Nette\ComponentModel\Nette\InvalidArgumentException("Component name must be non-empty alphanumeric string, '{$name}' given.");
        }
        if (isset($this->components[$name])) {
            throw new \RectorPrefix20210319\Nette\ComponentModel\Nette\InvalidStateException("Component with name '{$name}' already exists.");
        }
        // check circular reference
        $obj = $this;
        do {
            if ($obj === $component) {
                throw new \RectorPrefix20210319\Nette\ComponentModel\Nette\InvalidStateException("Circular reference detected while adding component '{$name}'.");
            }
            $obj = $obj->getParent();
        } while ($obj !== null);
        // user checking
        $this->validateChildComponent($component);
        if (isset($this->components[$insertBefore])) {
            $tmp = [];
            foreach ($this->components as $k => $v) {
                if ((string) $k === $insertBefore) {
                    $tmp[$name] = $component;
                }
                $tmp[$k] = $v;
            }
            $this->components = $tmp;
        } else {
            $this->components[$name] = $component;
        }
        try {
            $component->setParent($this, $name);
        } catch (\Throwable $e) {
            unset($this->components[$name]);
            // undo
            throw $e;
        }
        return $this;
    }
    /**
     * Removes the component from the container.
     */
    public function removeComponent(\RectorPrefix20210319\Nette\ComponentModel\IComponent $component) : void
    {
        $name = $component->getName();
        if (($this->components[$name] ?? null) !== $component) {
            throw new \RectorPrefix20210319\Nette\ComponentModel\Nette\InvalidArgumentException("Component named '{$name}' is not located in this container.");
        }
        unset($this->components[$name]);
        $component->setParent(null);
    }
    /**
     * Returns component specified by name or path.
     * @param  bool  $throw  throw exception if component doesn't exist?
     */
    public function getComponent(string $name, $throw = \true) : ?\RectorPrefix20210319\Nette\ComponentModel\IComponent
    {
        [$name] = $parts = \explode(self::NAME_SEPARATOR, $name, 2);
        if (!isset($this->components[$name])) {
            if (!\preg_match(self::NAME_REGEXP, $name)) {
                if ($throw) {
                    throw new \RectorPrefix20210319\Nette\ComponentModel\Nette\InvalidArgumentException("Component name must be non-empty alphanumeric string, '{$name}' given.");
                }
                return null;
            }
            $component = $this->createComponent($name);
            if ($component && !isset($this->components[$name])) {
                $this->addComponent($component, $name);
            }
        }
        $component = $this->components[$name] ?? null;
        if ($component !== null) {
            if (!isset($parts[1])) {
                return $component;
            } elseif ($component instanceof \RectorPrefix20210319\Nette\ComponentModel\IContainer) {
                return $component->getComponent($parts[1], $throw);
            } elseif ($throw) {
                throw new \RectorPrefix20210319\Nette\ComponentModel\Nette\InvalidArgumentException("Component with name '{$name}' is not container and cannot have '{$parts[1]}' component.");
            }
        } elseif ($throw) {
            $hint = \RectorPrefix20210319\Nette\ComponentModel\Nette\Utils\ObjectHelpers::getSuggestion(\array_merge(\array_map('strval', \array_keys($this->components)), \array_map('lcfirst', \preg_filter('#^createComponent([A-Z0-9].*)#', '$1', \get_class_methods($this)))), $name);
            throw new \RectorPrefix20210319\Nette\ComponentModel\Nette\InvalidArgumentException("Component with name '{$name}' does not exist" . ($hint ? ", did you mean '{$hint}'?" : '.'));
        }
        return null;
    }
    /**
     * Component factory. Delegates the creation of components to a createComponent<Name> method.
     */
    protected function createComponent(string $name) : ?\RectorPrefix20210319\Nette\ComponentModel\IComponent
    {
        $ucname = \ucfirst($name);
        $method = 'createComponent' . $ucname;
        if ($ucname !== $name && \method_exists($this, $method) && (new \ReflectionMethod($this, $method))->getName() === $method) {
            $component = $this->{$method}($name);
            if (!$component instanceof \RectorPrefix20210319\Nette\ComponentModel\IComponent && !isset($this->components[$name])) {
                $class = \get_class($this);
                throw new \RectorPrefix20210319\Nette\ComponentModel\Nette\UnexpectedValueException("Method {$class}::{$method}() did not return or create the desired component.");
            }
            return $component;
        }
        return null;
    }
    /**
     * Iterates over descendants components.
     * @return \Iterator<int|string, IComponent>
     * @param bool $deep
     * @param string $filterType
     */
    public final function getComponents($deep = \false, $filterType = null) : \Iterator
    {
        $iterator = new \RectorPrefix20210319\Nette\ComponentModel\RecursiveComponentIterator($this->components);
        if ($deep) {
            $iterator = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);
        }
        if ($filterType) {
            $iterator = new \CallbackFilterIterator($iterator, function ($item) use($filterType) {
                return $item instanceof $filterType;
            });
        }
        return $iterator;
    }
    /**
     * Descendant can override this method to disallow insert a child by throwing an Nette\InvalidStateException.
     * @throws Nette\InvalidStateException
     */
    protected function validateChildComponent(\RectorPrefix20210319\Nette\ComponentModel\IComponent $child) : void
    {
    }
    /********************* cloneable, serializable ****************d*g**/
    /**
     * Object cloning.
     */
    public function __clone()
    {
        if ($this->components) {
            $oldMyself = \reset($this->components)->getParent();
            \assert($oldMyself instanceof self);
            $oldMyself->cloning = $this;
            foreach ($this->components as $name => $component) {
                $this->components[$name] = clone $component;
            }
            $oldMyself->cloning = null;
        }
        // In the stubs, this class has no parent
        // parent::__clone();
    }
    /**
     * Is container cloning now?
     * @internal
     * @return $this|null
     */
    public final function _isCloning()
    {
        return $this->cloning;
    }
}
