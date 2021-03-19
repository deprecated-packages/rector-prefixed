<?php

declare (strict_types=1);
namespace RectorPrefix20210319;

use RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210319\Symplify\EasyCodingStandard\ValueObject\Option;
use RectorPrefix20210319\Symplify\EasyCodingStandard\ValueObject\Set\SetList;
return static function (\RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\RectorPrefix20210319\Symplify\EasyCodingStandard\ValueObject\Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests', __DIR__ . '/config', __DIR__ . '/ecs.php']);
    $parameters->set(\RectorPrefix20210319\Symplify\EasyCodingStandard\ValueObject\Option::SETS, [\RectorPrefix20210319\Symplify\EasyCodingStandard\ValueObject\Set\SetList::PSR_12, \RectorPrefix20210319\Symplify\EasyCodingStandard\ValueObject\Set\SetList::SYMPLIFY, \RectorPrefix20210319\Symplify\EasyCodingStandard\ValueObject\Set\SetList::COMMON, \RectorPrefix20210319\Symplify\EasyCodingStandard\ValueObject\Set\SetList::CLEAN_CODE]);
    $parameters->set(\RectorPrefix20210319\Symplify\EasyCodingStandard\ValueObject\Option::SKIP, [
        '*/Source/*',
        '*/Fixture/*',
        // breaks annotated code - removed on symplify dev-main
        \RectorPrefix20210319\PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer::class,
    ]);
    $parameters->set(\RectorPrefix20210319\Symplify\EasyCodingStandard\ValueObject\Option::LINE_ENDING, "\n");
};
