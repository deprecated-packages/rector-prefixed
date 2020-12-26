<?php

declare (strict_types=1);
namespace Symplify\MarkdownDiff\Bundle;

use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension;
final class MarkdownDiffBundle extends \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension();
    }
}
