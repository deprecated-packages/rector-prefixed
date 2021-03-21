<?php

declare (strict_types=1);
namespace RectorPrefix20210321\Nette\DI;

use RectorPrefix20210321\Nette\DI\Definitions\Definition;
if (\class_exists('Nette\\DI\\ContainerBuilder')) {
    return;
}
final class ContainerBuilder
{
    /**
     * @return \Nette\DI\Definitions\ServiceDefinition
     */
    public function addDefinition(?string $name, \RectorPrefix20210321\Nette\DI\Definitions\Definition $definition = null) : \RectorPrefix20210321\Nette\DI\Definitions\Definition
    {
    }
}
