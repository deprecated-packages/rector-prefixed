<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony4\Tests\Rector\MethodCall\ContainerGetToConstructorInjectionRector\Source;

use _PhpScoperb75b35f52b74\Symfony\Component\Console\Command\Command;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareParentCommand extends \_PhpScoperb75b35f52b74\Symfony\Component\Console\Command\Command
{
    public function getContainer() : \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
