<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Nette\ComponentModel;

if (\interface_exists('_PhpScoperabd03f0baf05\\Nette\\ComponentModel\\IComponent')) {
    return;
}
interface IComponent
{
    /**
     * Returns component specified by name or path.
     * @throws \Nette\InvalidArgumentException  if component doesn't exist
     */
    function getComponent(string $name) : ?\_PhpScoperabd03f0baf05\Nette\ComponentModel\IComponent;
}
