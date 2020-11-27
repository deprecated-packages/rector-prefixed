<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use Rector\Core\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopera143bcca66cb\PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use _PhpScopera143bcca66cb\PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use _PhpScopera143bcca66cb\PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use _PhpScopera143bcca66cb\PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use _PhpScopera143bcca66cb\PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use _PhpScopera143bcca66cb\PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use _PhpScopera143bcca66cb\PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopera143bcca66cb\PhpCsFixer\Fixer\Import\NoUnusedImportsFixer::class);
    $services->set(\_PhpScopera143bcca66cb\PhpCsFixer\Fixer\Import\OrderedImportsFixer::class);
    $services->set(\_PhpScopera143bcca66cb\PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer::class);
    $services->set(\_PhpScopera143bcca66cb\PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer::class);
    $services->set(\_PhpScopera143bcca66cb\PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer::class);
    $services->set(\_PhpScopera143bcca66cb\PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer::class);
    $services->set(\_PhpScopera143bcca66cb\PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer::class);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::SETS, [\Symplify\EasyCodingStandard\ValueObject\Set\SetList::DOCTRINE_ANNOTATIONS]);
};
