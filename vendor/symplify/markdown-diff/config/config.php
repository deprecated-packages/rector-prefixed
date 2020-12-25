<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use _PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Differ;
use _PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\MarkdownDiff\\', __DIR__ . '/../src');
    $services->set(\_PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Differ::class);
    // markdown
    $services->set('markdownDiffOutputBuilder', \_PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \_PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffOutputBuilder'));
    $services->set(\Symplify\MarkdownDiff\Differ\MarkdownDiffer::class)->arg('$markdownDiffer', \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffer'));
    $services->set(\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
