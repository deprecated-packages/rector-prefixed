<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Nette\ComponentModel;

if (\interface_exists('_PhpScoperbd5d0c5f7638\\Nette\\ComponentModel\\IComponent')) {
    return;
}
interface IComponent
{
    /**
     * Returns component specified by name or path.
     * @throws \Nette\InvalidArgumentException  if component doesn't exist
     */
    function getComponent(string $name) : ?\_PhpScoperbd5d0c5f7638\Nette\ComponentModel\IComponent;
}
