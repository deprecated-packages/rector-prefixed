<?php

declare (strict_types=1);
namespace RectorPrefix20210321\Nette\ComponentModel;

if (\interface_exists('Nette\\ComponentModel\\IComponent')) {
    return;
}
interface IComponent
{
    /**
     * Returns component specified by name or path.
     * @throws \Nette\InvalidArgumentException  if component doesn't exist
     */
    function getComponent(string $name) : ?\RectorPrefix20210321\Nette\ComponentModel\IComponent;
}
