<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use Rector\Core\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Import\NoUnusedImportsFixer::class);
    $services->set(\_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Import\OrderedImportsFixer::class);
    $services->set(\_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer::class);
    $services->set(\_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer::class);
    $services->set(\_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer::class);
    $services->set(\_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer::class);
    $services->set(\_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer::class);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::SETS, [\Symplify\EasyCodingStandard\ValueObject\Set\SetList::DOCTRINE_ANNOTATIONS]);
};
