<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use _PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase;
use Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector;
use Rector\CodingStyle\Rector\String_\SplitStringClassConstantToClassConstFetchRector;
use Rector\Core\Configuration\Option;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersion;
use Rector\DeadCode\Rector\ClassConst\RemoveUnusedClassConstantRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector;
use Rector\Restoration\ValueObject\InferParamFromClassMethodReturn;
use Rector\Set\ValueObject\SetList;
use Rector\SymfonyPhpConfig\Rector\MethodCall\AutoInPhpSymfonyConfigRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $configuration = \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Restoration\ValueObject\InferParamFromClassMethodReturn(\Rector\Core\Rector\AbstractRector::class, 'refactor', 'getNodeTypes')]);
    $services->set(\Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector::class)->call('configure', [[\Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector::INFER_PARAMS_FROM_CLASS_METHOD_RETURNS => $configuration]]);
    $services->set(\Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector::class)->call('configure', [[\Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector::TYPE_TO_PREFERENCE => [\_PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase::class => \Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector::PREFER_THIS]]]);
    $services->set(\Rector\SymfonyPhpConfig\Rector\MethodCall\AutoInPhpSymfonyConfigRector::class);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::SETS, [\Rector\Set\ValueObject\SetList::CODING_STYLE, \Rector\Set\ValueObject\SetList::CODE_QUALITY, \Rector\Set\ValueObject\SetList::CODE_QUALITY_STRICT, \Rector\Set\ValueObject\SetList::DEAD_CODE, \Rector\Set\ValueObject\SetList::NETTE_UTILS_CODE_QUALITY, \Rector\Set\ValueObject\SetList::SOLID, \Rector\Set\ValueObject\SetList::PRIVATIZATION, \Rector\Set\ValueObject\SetList::NAMING, \Rector\Set\ValueObject\SetList::ORDER, \Rector\Set\ValueObject\SetList::DEFLUENT, \Rector\Set\ValueObject\SetList::TYPE_DECLARATION, \Rector\Set\ValueObject\SetList::PHPUNIT_CODE_QUALITY, \Rector\Set\ValueObject\SetList::SYMFONY_AUTOWIRE]);
    $parameters->set(\Rector\Core\Configuration\Option::PATHS, [__DIR__ . '/src', __DIR__ . '/rules', __DIR__ . '/packages', __DIR__ . '/tests', __DIR__ . '/utils', __DIR__ . '/config/set']);
    $parameters->set(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
    $parameters->set(\Rector\Core\Configuration\Option::AUTOLOAD_PATHS, [__DIR__ . '/compiler/src']);
    $parameters->set(\Rector\Core\Configuration\Option::SKIP, [
        \Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class,
        \Rector\CodingStyle\Rector\String_\SplitStringClassConstantToClassConstFetchRector::class,
        // false positives on constants used in rector-ci.php
        \Rector\DeadCode\Rector\ClassConst\RemoveUnusedClassConstantRector::class,
        // test paths
        '*/Fixture/*',
        '*/Source/*',
        '*/Expected/*',
        __DIR__ . '/packages/doctrine-annotation-generated/src',
        // template files
        __DIR__ . '/packages/rector-generator/templates',
        // public api
        __DIR__ . '/packages/rector-generator/src/ValueObject/RectorRecipe.php',
    ]);
    # so Rector code is still PHP 7.2 compatible
    $parameters->set(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \Rector\Core\ValueObject\PhpVersion::PHP_7_2);
    $parameters->set(\Rector\Core\Configuration\Option::ENABLE_CACHE, \true);
};
