<?php

declare (strict_types=1);
namespace Symplify\MarkdownDiff\Bundle;

use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension;
final class MarkdownDiffBundle extends \_PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension();
    }
}
