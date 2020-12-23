<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use _PhpScoper0a2ac50786fa\Rector\ConsoleDiffer\DifferAndFormatter;
use _PhpScoper0a2ac50786fa\Rector\ConsoleDiffer\MarkdownDifferAndFormatter;
use _PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Differ;
use _PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;
use _PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use _PhpScoper0a2ac50786fa\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
use _PhpScoper0a2ac50786fa\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\ConsoleDiffer\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper0a2ac50786fa\Rector\ConsoleDiffer\DifferAndFormatter::class)->arg('$differ', \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref('differ'));
    $services->set(\_PhpScoper0a2ac50786fa\Rector\ConsoleDiffer\MarkdownDifferAndFormatter::class)->arg('$markdownDiffer', \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffer'));
    $services->set('diffOutputBuilder', \_PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder::class)->arg('$options', ['fromFile' => 'Original', 'toFile' => 'New']);
    $services->set('differ', \_PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref('diffOutputBuilder'));
    $services->set('markdownDiffOutputBuilder', \_PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a2ac50786fa\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \_PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffOutputBuilder'));
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter::class);
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer::class);
};
