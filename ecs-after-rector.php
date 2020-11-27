<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use Rector\Core\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use _PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use _PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use _PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use _PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use _PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use _PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Import\NoUnusedImportsFixer::class);
    $services->set(\_PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Import\OrderedImportsFixer::class);
    $services->set(\_PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer::class);
    $services->set(\_PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer::class);
    $services->set(\_PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer::class);
    $services->set(\_PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer::class);
    $services->set(\_PhpScoperbd5d0c5f7638\PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer::class);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::SETS, [\Symplify\EasyCodingStandard\ValueObject\Set\SetList::DOCTRINE_ANNOTATIONS]);
};
