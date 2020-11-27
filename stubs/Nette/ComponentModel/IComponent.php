<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Nette\ComponentModel;

if (\interface_exists('_PhpScoper88fe6e0ad041\\Nette\\ComponentModel\\IComponent')) {
    return;
}
interface IComponent
{
    /**
     * Returns component specified by name or path.
     * @throws \Nette\InvalidArgumentException  if component doesn't exist
     */
    function getComponent(string $name) : ?\_PhpScoper88fe6e0ad041\Nette\ComponentModel\IComponent;
}
