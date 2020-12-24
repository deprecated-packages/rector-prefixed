<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\SebastianBergmann\Diff\Differ;
use _PhpScoper0a6b37af0871\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use _PhpScoper0a6b37af0871\Symplify\MarkdownDiff\Differ\MarkdownDiffer;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\MarkdownDiff\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper0a6b37af0871\SebastianBergmann\Diff\Differ::class);
    // markdown
    $services->set('markdownDiffOutputBuilder', \_PhpScoper0a6b37af0871\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoper0a6b37af0871\Symplify\MarkdownDiff\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \_PhpScoper0a6b37af0871\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffOutputBuilder'));
    $services->set(\_PhpScoper0a6b37af0871\Symplify\MarkdownDiff\Differ\MarkdownDiffer::class)->arg('$markdownDiffer', \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\service('markdownDiffer'));
    $services->set(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
