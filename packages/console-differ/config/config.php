<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use _PhpScoper0a6b37af0871\Rector\ConsoleDiffer\DifferAndFormatter;
use _PhpScoper0a6b37af0871\Rector\ConsoleDiffer\MarkdownDifferAndFormatter;
use _PhpScoper0a6b37af0871\SebastianBergmann\Diff\Differ;
use _PhpScoper0a6b37af0871\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;
use _PhpScoper0a6b37af0871\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use _PhpScoper0a6b37af0871\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
use _PhpScoper0a6b37af0871\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\ConsoleDiffer\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper0a6b37af0871\Rector\ConsoleDiffer\DifferAndFormatter::class)->arg('$differ', \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref('differ'));
    $services->set(\_PhpScoper0a6b37af0871\Rector\ConsoleDiffer\MarkdownDifferAndFormatter::class)->arg('$markdownDiffer', \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffer'));
    $services->set('diffOutputBuilder', \_PhpScoper0a6b37af0871\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder::class)->arg('$options', ['fromFile' => 'Original', 'toFile' => 'New']);
    $services->set('differ', \_PhpScoper0a6b37af0871\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref('diffOutputBuilder'));
    $services->set('markdownDiffOutputBuilder', \_PhpScoper0a6b37af0871\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \_PhpScoper0a6b37af0871\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffOutputBuilder'));
    $services->set(\_PhpScoper0a6b37af0871\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter::class);
    $services->set(\_PhpScoper0a6b37af0871\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer::class);
};
