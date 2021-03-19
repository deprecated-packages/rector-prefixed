<?php

declare (strict_types=1);
namespace RectorPrefix20210319\Nette\ComponentModel;

if (\interface_exists('RectorPrefix20210319\\Nette\\ComponentModel\\IComponent')) {
    return;
}
interface IComponent
{
    /**
     * Returns component specified by name or path.
     * @throws \Nette\InvalidArgumentException  if component doesn't exist
     */
    function getComponent(string $name) : ?\RectorPrefix20210319\Nette\ComponentModel\IComponent;
}