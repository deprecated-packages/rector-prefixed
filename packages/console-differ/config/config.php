<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use _PhpScopere8e811afab72\Rector\ConsoleDiffer\DifferAndFormatter;
use _PhpScopere8e811afab72\Rector\ConsoleDiffer\MarkdownDifferAndFormatter;
use _PhpScopere8e811afab72\SebastianBergmann\Diff\Differ;
use _PhpScopere8e811afab72\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;
use _PhpScopere8e811afab72\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use _PhpScopere8e811afab72\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
use _PhpScopere8e811afab72\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\ConsoleDiffer\\', __DIR__ . '/../src');
    $services->set(\_PhpScopere8e811afab72\Rector\ConsoleDiffer\DifferAndFormatter::class)->arg('$differ', \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref('differ'));
    $services->set(\_PhpScopere8e811afab72\Rector\ConsoleDiffer\MarkdownDifferAndFormatter::class)->arg('$markdownDiffer', \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffer'));
    $services->set('diffOutputBuilder', \_PhpScopere8e811afab72\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder::class)->arg('$options', ['fromFile' => 'Original', 'toFile' => 'New']);
    $services->set('differ', \_PhpScopere8e811afab72\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref('diffOutputBuilder'));
    $services->set('markdownDiffOutputBuilder', \_PhpScopere8e811afab72\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \_PhpScopere8e811afab72\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffOutputBuilder'));
    $services->set(\_PhpScopere8e811afab72\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer::class);
};
