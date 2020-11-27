<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use _PhpScoper26e51eeacccf\PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\MethodDeclarationSniff;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Phpdoc\PhpdocTypesFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use _PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use _PhpScoper26e51eeacccf\SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\CodingStandard\Sniffs\Debug\CommentedOutCodeSniff;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer::class);
    $services->set(\Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer::class);
    $services->set(\_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer::class)->call('configure', [['annotations' => ['throws', 'author', 'package', 'group']]]);
    $services->set(\Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer::class);
    $services->set(\_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer::class)->call('configure', [['allow_mixed' => \true]]);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::PATHS, [__DIR__ . '/bin', __DIR__ . '/src', __DIR__ . '/packages', __DIR__ . '/rules', __DIR__ . '/tests', __DIR__ . '/utils', __DIR__ . '/config', __DIR__ . '/ecs.php', __DIR__ . '/rector.php', __DIR__ . '/rector-ci.php', __DIR__ . '/config/set']);
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::SETS, [\Symplify\EasyCodingStandard\ValueObject\Set\SetList::PSR_12, \Symplify\EasyCodingStandard\ValueObject\Set\SetList::PHP_70, \Symplify\EasyCodingStandard\ValueObject\Set\SetList::PHP_71, \Symplify\EasyCodingStandard\ValueObject\Set\SetList::SYMPLIFY, \Symplify\EasyCodingStandard\ValueObject\Set\SetList::COMMON, \Symplify\EasyCodingStandard\ValueObject\Set\SetList::CLEAN_CODE]);
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::SKIP, [
        '*/Source/*',
        '*/Fixture/*',
        '*/Expected/*',
        # generated from /vendor
        __DIR__ . '/packages/doctrine-annotation-generated/src/ConstantPreservingDocParser.php',
        __DIR__ . '/packages/doctrine-annotation-generated/src/ConstantPreservingAnnotationReader.php',
        // template files
        __DIR__ . '/packages/rector-generator/templates',
        // broken
        \_PhpScoper26e51eeacccf\SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff::class,
        \_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer::class,
        \_PhpScoper26e51eeacccf\PHP_CodeSniffer\Standards\PSR2\Sniffs\Methods\MethodDeclarationSniff::class . '.Underscore',
        \_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Phpdoc\PhpdocTypesFixer::class => [__DIR__ . '/rules/php74/src/Rector/Double/RealToFloatTypeCastRector.php'],
        \Symplify\CodingStandard\Sniffs\Debug\CommentedOutCodeSniff::class . '.Found' => [__DIR__ . '/rules/php72/src/Rector/Assign/ListEachRector.php', __DIR__ . '/rules/dead-code/src/Rector/FunctionLike/RemoveOverriddenValuesRector.php', __DIR__ . '/rules/php-spec-to-phpunit/src/Rector/MethodCall/PhpSpecPromisesToPHPUnitAssertRector.php'],
        \_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer::class => [__DIR__ . '/packages/better-php-doc-parser/tests/PhpDocInfo/PhpDocInfo/PhpDocInfoTest.php', __DIR__ . '/tests/PhpParser/Node/NodeFactoryTest.php', '*TypeResolverTest.php'],
        \_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer::class,
        // breaks on-purpose annotated variables
        \_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer::class,
        // buggy with specific markdown snippet file in docs/rules_overview.md
        \Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer::class,
        \_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer::class,
        \_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Strict\StrictComparisonFixer::class => [__DIR__ . '/rules/polyfill/src/ConditionEvaluator.php'],
        // bugged for some reason
        \_PhpScoper26e51eeacccf\PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer::class => [__DIR__ . '/rules/order/src/Rector/Class_/OrderPublicInterfaceMethodRector.php'],
    ]);
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::LINE_ENDING, "\n");
};
