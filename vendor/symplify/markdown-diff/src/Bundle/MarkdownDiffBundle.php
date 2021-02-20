<?php

declare (strict_types=1);
namespace RectorPrefix20210220\Symplify\MarkdownDiff\Bundle;

use RectorPrefix20210220\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20210220\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210220\Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension;
final class MarkdownDiffBundle extends \RectorPrefix20210220\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\RectorPrefix20210220\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210220\Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension();
    }
}
