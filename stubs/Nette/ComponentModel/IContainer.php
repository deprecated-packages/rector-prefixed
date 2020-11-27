<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Nette\ComponentModel;

// mimics: https://github.com/nette/component-model/blob/master/src/ComponentModel/IContainer.php
if (\interface_exists('_PhpScoper88fe6e0ad041\\Nette\\ComponentModel\\IContainer')) {
    return;
}
// mimics: https://github.com/nette/component-model/blob/master/src/ComponentModel/IContainer.php
interface IContainer extends \_PhpScoper88fe6e0ad041\Nette\ComponentModel\IComponent
{
    /**
     * Adds the component to the container.
     * @return static
     */
    function addComponent(\_PhpScoper88fe6e0ad041\Nette\ComponentModel\IComponent $component, ?string $name);
    /**
     * Removes the component from the container.
     */
    function removeComponent(\_PhpScoper88fe6e0ad041\Nette\ComponentModel\IComponent $component) : void;
    /**
     * Returns component specified by name or path.
     * @throws \Nette\InvalidArgumentException  if component doesn't exist
     */
    function getComponent(string $name) : ?\_PhpScoper88fe6e0ad041\Nette\ComponentModel\IComponent;
    /**
     * Iterates over descendants components.
     * @return \Iterator<int|string,IComponent>
     */
    function getComponents() : \Iterator;
}
