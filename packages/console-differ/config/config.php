<?php

declare (strict_types=1);
namespace RectorPrefix20201230;

use Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use Rector\ConsoleDiffer\DifferAndFormatter;
use Rector\ConsoleDiffer\MarkdownDifferAndFormatter;
use RectorPrefix20201230\SebastianBergmann\Diff\Differ;
use RectorPrefix20201230\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;
use RectorPrefix20201230\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use RectorPrefix20201230\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
use RectorPrefix20201230\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer;
return static function (\RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\ConsoleDiffer\\', __DIR__ . '/../src');
    $services->set(\Rector\ConsoleDiffer\DifferAndFormatter::class)->arg('$differ', \RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\Configurator\ref('differ'));
    $services->set(\Rector\ConsoleDiffer\MarkdownDifferAndFormatter::class)->arg('$markdownDiffer', \RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffer'));
    $services->set('diffOutputBuilder', \RectorPrefix20201230\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder::class)->arg('$options', ['fromFile' => 'Original', 'toFile' => 'New']);
    $services->set('differ', \RectorPrefix20201230\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\Configurator\ref('diffOutputBuilder'));
    $services->set('markdownDiffOutputBuilder', \RectorPrefix20201230\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \RectorPrefix20201230\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \RectorPrefix20201230\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffOutputBuilder'));
    $services->set(\RectorPrefix20201230\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter::class);
    $services->set(\RectorPrefix20201230\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer::class);
};
