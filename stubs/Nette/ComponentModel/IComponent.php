<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Nette\ComponentModel;

if (\interface_exists('_PhpScoper26e51eeacccf\\Nette\\ComponentModel\\IComponent')) {
    return;
}
interface IComponent
{
    /**
     * Returns component specified by name or path.
     * @throws \Nette\InvalidArgumentException  if component doesn't exist
     */
    function getComponent(string $name) : ?\_PhpScoper26e51eeacccf\Nette\ComponentModel\IComponent;
}
