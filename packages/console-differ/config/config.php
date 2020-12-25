<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use Rector\ConsoleDiffer\DifferAndFormatter;
use Rector\ConsoleDiffer\MarkdownDifferAndFormatter;
use _PhpScoper50d83356d739\SebastianBergmann\Diff\Differ;
use _PhpScoper50d83356d739\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;
use _PhpScoper50d83356d739\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper50d83356d739\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
use Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\ConsoleDiffer\\', __DIR__ . '/../src');
    $services->set(\Rector\ConsoleDiffer\DifferAndFormatter::class)->arg('$differ', \_PhpScoper50d83356d739\Symfony\Component\DependencyInjection\Loader\Configurator\ref('differ'));
    $services->set(\Rector\ConsoleDiffer\MarkdownDifferAndFormatter::class)->arg('$markdownDiffer', \_PhpScoper50d83356d739\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffer'));
    $services->set('diffOutputBuilder', \_PhpScoper50d83356d739\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder::class)->arg('$options', ['fromFile' => 'Original', 'toFile' => 'New']);
    $services->set('differ', \_PhpScoper50d83356d739\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoper50d83356d739\Symfony\Component\DependencyInjection\Loader\Configurator\ref('diffOutputBuilder'));
    $services->set('markdownDiffOutputBuilder', \_PhpScoper50d83356d739\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\_PhpScoper50d83356d739\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \_PhpScoper50d83356d739\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoper50d83356d739\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffOutputBuilder'));
    $services->set(\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter::class);
    $services->set(\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer::class);
};
