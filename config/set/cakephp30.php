<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector;
use _PhpScopere8e811afab72\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # @see https://github.com/cakephp/upgrade/tree/master/src/Shell/Task
    $services->set(\_PhpScopere8e811afab72\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # see https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/RenameClassesTask.php#L37
        '_PhpScopere8e811afab72\\Cake\\Network\\Http\\HttpSocket' => '_PhpScopere8e811afab72\\Cake\\Network\\Http\\Client',
        '_PhpScopere8e811afab72\\Cake\\Model\\ConnectionManager' => '_PhpScopere8e811afab72\\Cake\\Database\\ConnectionManager',
        '_PhpScopere8e811afab72\\Cake\\TestSuite\\CakeTestCase' => '_PhpScopere8e811afab72\\Cake\\TestSuite\\TestCase',
        '_PhpScopere8e811afab72\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => '_PhpScopere8e811afab72\\Cake\\TestSuite\\Fixture\\TestFixture',
        '_PhpScopere8e811afab72\\Cake\\Utility\\String' => '_PhpScopere8e811afab72\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        '_PhpScopere8e811afab72\\Cake\\Configure\\PhpReader' => '_PhpScopere8e811afab72\\Cake\\Core\\Configure\\EnginePhpConfig',
        '_PhpScopere8e811afab72\\Cake\\Configure\\IniReader' => '_PhpScopere8e811afab72\\Cake\\Core\\Configure\\EngineIniConfig',
        '_PhpScopere8e811afab72\\Cake\\Configure\\ConfigReaderInterface' => '_PhpScopere8e811afab72\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => '_PhpScopere8e811afab72\\Cake\\Network\\Request',
    ]]]);
};
