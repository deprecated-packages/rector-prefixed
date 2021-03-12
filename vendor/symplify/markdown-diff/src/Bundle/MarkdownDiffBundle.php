<?php

declare (strict_types=1);
namespace RectorPrefix20210312\Symplify\MarkdownDiff\Bundle;

use RectorPrefix20210312\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210312\Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension;
final class MarkdownDiffBundle extends \RectorPrefix20210312\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : \RectorPrefix20210312\Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension
    {
        return new \RectorPrefix20210312\Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension();
    }
}
