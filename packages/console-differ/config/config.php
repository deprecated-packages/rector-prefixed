<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use _PhpScoperb75b35f52b74\Rector\ConsoleDiffer\DifferAndFormatter;
use _PhpScoperb75b35f52b74\Rector\ConsoleDiffer\MarkdownDifferAndFormatter;
use _PhpScoperb75b35f52b74\SebastianBergmann\Diff\Differ;
use _PhpScoperb75b35f52b74\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;
use _PhpScoperb75b35f52b74\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use _PhpScoperb75b35f52b74\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
use _PhpScoperb75b35f52b74\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\ConsoleDiffer\\', __DIR__ . '/../src');
    $services->set(\_PhpScoperb75b35f52b74\Rector\ConsoleDiffer\DifferAndFormatter::class)->arg('$differ', \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref('differ'));
    $services->set(\_PhpScoperb75b35f52b74\Rector\ConsoleDiffer\MarkdownDifferAndFormatter::class)->arg('$markdownDiffer', \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffer'));
    $services->set('diffOutputBuilder', \_PhpScoperb75b35f52b74\SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder::class)->arg('$options', ['fromFile' => 'Original', 'toFile' => 'New']);
    $services->set('differ', \_PhpScoperb75b35f52b74\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref('diffOutputBuilder'));
    $services->set('markdownDiffOutputBuilder', \_PhpScoperb75b35f52b74\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Rector\ConsoleDiffer\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class), 'create']);
    $services->set('markdownDiffer', \_PhpScoperb75b35f52b74\SebastianBergmann\Diff\Differ::class)->arg('$outputBuilder', \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref('markdownDiffOutputBuilder'));
    $services->set(\_PhpScoperb75b35f52b74\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\ConsoleColorDiff\Console\Output\ConsoleDiffer::class);
};
