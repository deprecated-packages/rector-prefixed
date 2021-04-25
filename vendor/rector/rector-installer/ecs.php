<?php

namespace RectorPrefix20210425;

use RectorPrefix20210425\PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use RectorPrefix20210425\PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use RectorPrefix20210425\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210425\Symplify\EasyCodingStandard\ValueObject\Option;
use RectorPrefix20210425\Symplify\EasyCodingStandard\ValueObject\Set\SetList;
return static function (\RectorPrefix20210425\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\RectorPrefix20210425\PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer::class)->call('configure', [['annotations' => ['throws', 'author', 'package', 'group', 'required', 'phpstan-ignore-line', 'phpstan-ignore-next-line']]]);
    $services->set(\RectorPrefix20210425\PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer::class)->call('configure', [['allow_mixed' => \true]]);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\RectorPrefix20210425\Symplify\EasyCodingStandard\ValueObject\Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);
    $parameters->set(\RectorPrefix20210425\Symplify\EasyCodingStandard\ValueObject\Option::SETS, [\RectorPrefix20210425\Symplify\EasyCodingStandard\ValueObject\Set\SetList::PSR_12, \RectorPrefix20210425\Symplify\EasyCodingStandard\ValueObject\Set\SetList::SYMPLIFY, \RectorPrefix20210425\Symplify\EasyCodingStandard\ValueObject\Set\SetList::COMMON, \RectorPrefix20210425\Symplify\EasyCodingStandard\ValueObject\Set\SetList::CLEAN_CODE]);
};
