<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use RectorPrefix2020DecSat\SebastianBergmann\Diff\Differ;
use RectorPrefix2020DecSat\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\MarkdownDiff\\', __DIR__ . '/../src');
    $services->set(\RectorPrefix2020DecSat\SebastianBergmann\Diff\Differ::class);
    // markdown
    $services->set('markdownDiffOutputBuilder', \RectorPrefix2020DecSat\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \RectorPrefix2020DecSat\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffOutputBuilder'));
    $services->set(\Symplify\MarkdownDiff\Differ\MarkdownDiffer::class)->arg('$markdownDiffer', \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffer'));
    $services->set(\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
