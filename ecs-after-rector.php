<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use Rector\Core\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use _PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use _PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use _PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use _PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use _PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use _PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Import\NoUnusedImportsFixer::class);
    $services->set(\_PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Import\OrderedImportsFixer::class);
    $services->set(\_PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer::class);
    $services->set(\_PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer::class);
    $services->set(\_PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer::class);
    $services->set(\_PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer::class);
    $services->set(\_PhpScoper88fe6e0ad041\PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer::class);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::SETS, [\Symplify\EasyCodingStandard\ValueObject\Set\SetList::DOCTRINE_ANNOTATIONS]);
};
