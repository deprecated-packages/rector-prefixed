<?php

declare (strict_types=1);
namespace RectorPrefix20201227;

use RectorPrefix20201227\SebastianBergmann\Diff\Differ;
use RectorPrefix20201227\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20201227\Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use RectorPrefix20201227\Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use RectorPrefix20201227\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\MarkdownDiff\\', __DIR__ . '/../src');
    $services->set(\RectorPrefix20201227\SebastianBergmann\Diff\Differ::class);
    // markdown
    $services->set('markdownDiffOutputBuilder', \RectorPrefix20201227\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20201227\Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \RectorPrefix20201227\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffOutputBuilder'));
    $services->set(\RectorPrefix20201227\Symplify\MarkdownDiff\Differ\MarkdownDiffer::class)->arg('$markdownDiffer', \RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffer'));
    $services->set(\RectorPrefix20201227\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
