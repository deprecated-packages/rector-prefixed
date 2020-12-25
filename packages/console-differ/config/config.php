<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use Rector\ConsoleDiffer\DifferAndFormatter;
use Rector\ConsoleDiffer\MarkdownDifferAndFormatter;
use _PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Differ;
use _PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;
use _PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
use Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\ConsoleDiffer\\', __DIR__ . '/../src');
    $services->set(\Rector\ConsoleDiffer\DifferAndFormatter::class)->arg('$differ', \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ref('differ'));
    $services->set(\Rector\ConsoleDiffer\MarkdownDifferAndFormatter::class)->arg('$markdownDiffer', \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffer'));
    $services->set('diffOutputBuilder', \_PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder::class)->arg('$options', ['fromFile' => 'Original', 'toFile' => 'New']);
    $services->set('differ', \_PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ref('diffOutputBuilder'));
    $services->set('markdownDiffOutputBuilder', \_PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \_PhpScoperbf340cb0be9d\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffOutputBuilder'));
    $services->set(\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter::class);
    $services->set(\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer::class);
};
