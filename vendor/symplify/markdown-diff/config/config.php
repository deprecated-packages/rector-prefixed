<?php

declare (strict_types=1);
namespace RectorPrefix20210110;

use RectorPrefix20210110\SebastianBergmann\Diff\Differ;
use RectorPrefix20210110\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use RectorPrefix20210110\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210110\Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use RectorPrefix20210110\Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use RectorPrefix20210110\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function RectorPrefix20210110\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\RectorPrefix20210110\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('RectorPrefix20210110\Symplify\\MarkdownDiff\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
    $services->set(\RectorPrefix20210110\SebastianBergmann\Diff\Differ::class);
    // markdown
    $services->set('markdownDiffOutputBuilder', \RectorPrefix20210110\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\RectorPrefix20210110\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20210110\Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \RectorPrefix20210110\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \RectorPrefix20210110\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffOutputBuilder'));
    $services->set(\RectorPrefix20210110\Symplify\MarkdownDiff\Differ\MarkdownDiffer::class)->arg('$markdownDiffer', \RectorPrefix20210110\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffer'));
    $services->set(\RectorPrefix20210110\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
