<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector;
use Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # @see https://github.com/cakephp/upgrade/tree/master/src/Shell/Task
    $services->set(\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector::class);
    $services->set(\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # see https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/RenameClassesTask.php#L37
        '_PhpScopera143bcca66cb\\Cake\\Network\\Http\\HttpSocket' => '_PhpScopera143bcca66cb\\Cake\\Network\\Http\\Client',
        '_PhpScopera143bcca66cb\\Cake\\Model\\ConnectionManager' => '_PhpScopera143bcca66cb\\Cake\\Database\\ConnectionManager',
        '_PhpScopera143bcca66cb\\Cake\\TestSuite\\CakeTestCase' => '_PhpScopera143bcca66cb\\Cake\\TestSuite\\TestCase',
        '_PhpScopera143bcca66cb\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => '_PhpScopera143bcca66cb\\Cake\\TestSuite\\Fixture\\TestFixture',
        '_PhpScopera143bcca66cb\\Cake\\Utility\\String' => '_PhpScopera143bcca66cb\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        '_PhpScopera143bcca66cb\\Cake\\Configure\\PhpReader' => '_PhpScopera143bcca66cb\\Cake\\Core\\Configure\\EnginePhpConfig',
        '_PhpScopera143bcca66cb\\Cake\\Configure\\IniReader' => '_PhpScopera143bcca66cb\\Cake\\Core\\Configure\\EngineIniConfig',
        '_PhpScopera143bcca66cb\\Cake\\Configure\\ConfigReaderInterface' => '_PhpScopera143bcca66cb\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => '_PhpScopera143bcca66cb\\Cake\\Network\\Request',
    ]]]);
};
