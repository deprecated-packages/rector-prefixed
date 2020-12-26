<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use Rector\ConsoleDiffer\DifferAndFormatter;
use Rector\ConsoleDiffer\MarkdownDifferAndFormatter;
use RectorPrefix2020DecSat\SebastianBergmann\Diff\Differ;
use RectorPrefix2020DecSat\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;
use RectorPrefix2020DecSat\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
use Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\ConsoleDiffer\\', __DIR__ . '/../src');
    $services->set(\Rector\ConsoleDiffer\DifferAndFormatter::class)->arg('$differ', \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref('differ'));
    $services->set(\Rector\ConsoleDiffer\MarkdownDifferAndFormatter::class)->arg('$markdownDiffer', \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffer'));
    $services->set('diffOutputBuilder', \RectorPrefix2020DecSat\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder::class)->arg('$options', ['fromFile' => 'Original', 'toFile' => 'New']);
    $services->set('differ', \RectorPrefix2020DecSat\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref('diffOutputBuilder'));
    $services->set('markdownDiffOutputBuilder', \RectorPrefix2020DecSat\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \RectorPrefix2020DecSat\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffOutputBuilder'));
    $services->set(\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter::class);
    $services->set(\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer::class);
};
