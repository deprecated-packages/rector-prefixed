<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Nette\ComponentModel;

// mimics: https://github.com/nette/component-model/blob/master/src/ComponentModel/IContainer.php
if (\interface_exists('_PhpScoperbd5d0c5f7638\\Nette\\ComponentModel\\IContainer')) {
    return;
}
// mimics: https://github.com/nette/component-model/blob/master/src/ComponentModel/IContainer.php
interface IContainer extends \_PhpScoperbd5d0c5f7638\Nette\ComponentModel\IComponent
{
    /**
     * Adds the component to the container.
     * @return static
     */
    function addComponent(\_PhpScoperbd5d0c5f7638\Nette\ComponentModel\IComponent $component, ?string $name);
    /**
     * Removes the component from the container.
     */
    function removeComponent(\_PhpScoperbd5d0c5f7638\Nette\ComponentModel\IComponent $component) : void;
    /**
     * Returns component specified by name or path.
     * @throws \Nette\InvalidArgumentException  if component doesn't exist
     */
    function getComponent(string $name) : ?\_PhpScoperbd5d0c5f7638\Nette\ComponentModel\IComponent;
    /**
     * Iterates over descendants components.
     * @return \Iterator<int|string,IComponent>
     */
    function getComponents() : \Iterator;
}
