<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\ConsoleDiffer\DifferAndFormatter;
use _PhpScoper2a4e7ab1ecbc\Rector\ConsoleDiffer\MarkdownDifferAndFormatter;
use _PhpScoper2a4e7ab1ecbc\SebastianBergmann\Diff\Differ;
use _PhpScoper2a4e7ab1ecbc\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;
use _PhpScoper2a4e7ab1ecbc\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use _PhpScoper2a4e7ab1ecbc\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
use _PhpScoper2a4e7ab1ecbc\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\ConsoleDiffer\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\ConsoleDiffer\DifferAndFormatter::class)->arg('$differ', \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref('differ'));
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\ConsoleDiffer\MarkdownDifferAndFormatter::class)->arg('$markdownDiffer', \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffer'));
    $services->set('diffOutputBuilder', \_PhpScoper2a4e7ab1ecbc\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder::class)->arg('$options', ['fromFile' => 'Original', 'toFile' => 'New']);
    $services->set('differ', \_PhpScoper2a4e7ab1ecbc\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref('diffOutputBuilder'));
    $services->set('markdownDiffOutputBuilder', \_PhpScoper2a4e7ab1ecbc\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper2a4e7ab1ecbc\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \_PhpScoper2a4e7ab1ecbc\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffOutputBuilder'));
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer::class);
};
