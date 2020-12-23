<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Differ;
use _PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use _PhpScoper0a2ac50786fa\Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\MarkdownDiff\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Differ::class);
    // markdown
    $services->set('markdownDiffOutputBuilder', \_PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoper0a2ac50786fa\Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \_PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffOutputBuilder'));
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\MarkdownDiff\Differ\MarkdownDiffer::class)->arg('$markdownDiffer', \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffer'));
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
