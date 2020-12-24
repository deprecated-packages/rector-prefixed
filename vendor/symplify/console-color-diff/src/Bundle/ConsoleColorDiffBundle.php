<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\ConsoleColorDiff\Bundle;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScopere8e811afab72\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension;
final class ConsoleColorDiffBundle extends \_PhpScopere8e811afab72\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScopere8e811afab72\Symplify\ConsoleColorDiff\DependencyInjection\Extension\ConsoleColorDiffExtension();
    }
}
