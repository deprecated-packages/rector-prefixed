<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Nette\ComponentModel;

if (\interface_exists('_PhpScopera143bcca66cb\\Nette\\ComponentModel\\IComponent')) {
    return;
}
interface IComponent
{
    /**
     * Returns component specified by name or path.
     * @throws \Nette\InvalidArgumentException  if component doesn't exist
     */
    function getComponent(string $name) : ?\_PhpScopera143bcca66cb\Nette\ComponentModel\IComponent;
}
