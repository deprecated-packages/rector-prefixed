<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # @see https://github.com/cakephp/upgrade/tree/master/src/Shell/Task
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # see https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/RenameClassesTask.php#L37
        '_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Http\\HttpSocket' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Http\\Client',
        '_PhpScoper2a4e7ab1ecbc\\Cake\\Model\\ConnectionManager' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Database\\ConnectionManager',
        '_PhpScoper2a4e7ab1ecbc\\Cake\\TestSuite\\CakeTestCase' => '_PhpScoper2a4e7ab1ecbc\\Cake\\TestSuite\\TestCase',
        '_PhpScoper2a4e7ab1ecbc\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => '_PhpScoper2a4e7ab1ecbc\\Cake\\TestSuite\\Fixture\\TestFixture',
        '_PhpScoper2a4e7ab1ecbc\\Cake\\Utility\\String' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        '_PhpScoper2a4e7ab1ecbc\\Cake\\Configure\\PhpReader' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Core\\Configure\\EnginePhpConfig',
        '_PhpScoper2a4e7ab1ecbc\\Cake\\Configure\\IniReader' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Core\\Configure\\EngineIniConfig',
        '_PhpScoper2a4e7ab1ecbc\\Cake\\Configure\\ConfigReaderInterface' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => '_PhpScoper2a4e7ab1ecbc\\Cake\\Network\\Request',
    ]]]);
};
