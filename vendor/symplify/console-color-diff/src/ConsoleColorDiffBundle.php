<?php

declare (strict_types=1);
namespace Symplify\ConsoleColorDiff;

use _PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
