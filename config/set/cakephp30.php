<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector;
use Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # @see https://github.com/cakephp/upgrade/tree/master/src/Shell/Task
    $services->set(\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector::class);
    $services->set(\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # see https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/RenameClassesTask.php#L37
        '_PhpScoperbf340cb0be9d\\Cake\\Network\\Http\\HttpSocket' => '_PhpScoperbf340cb0be9d\\Cake\\Network\\Http\\Client',
        '_PhpScoperbf340cb0be9d\\Cake\\Model\\ConnectionManager' => '_PhpScoperbf340cb0be9d\\Cake\\Database\\ConnectionManager',
        '_PhpScoperbf340cb0be9d\\Cake\\TestSuite\\CakeTestCase' => '_PhpScoperbf340cb0be9d\\Cake\\TestSuite\\TestCase',
        '_PhpScoperbf340cb0be9d\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => '_PhpScoperbf340cb0be9d\\Cake\\TestSuite\\Fixture\\TestFixture',
        '_PhpScoperbf340cb0be9d\\Cake\\Utility\\String' => '_PhpScoperbf340cb0be9d\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        '_PhpScoperbf340cb0be9d\\Cake\\Configure\\PhpReader' => '_PhpScoperbf340cb0be9d\\Cake\\Core\\Configure\\EnginePhpConfig',
        '_PhpScoperbf340cb0be9d\\Cake\\Configure\\IniReader' => '_PhpScoperbf340cb0be9d\\Cake\\Core\\Configure\\EngineIniConfig',
        '_PhpScoperbf340cb0be9d\\Cake\\Configure\\ConfigReaderInterface' => '_PhpScoperbf340cb0be9d\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => '_PhpScoperbf340cb0be9d\\Cake\\Network\\Request',
    ]]]);
};
