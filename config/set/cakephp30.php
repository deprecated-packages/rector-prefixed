<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2;

use Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector;
use Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # @see https://github.com/cakephp/upgrade/tree/master/src/Shell/Task
    $services->set(\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector::class);
    $services->set(\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # see https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/RenameClassesTask.php#L37
        '_PhpScoperf18a0c41e2d2\\Cake\\Network\\Http\\HttpSocket' => '_PhpScoperf18a0c41e2d2\\Cake\\Network\\Http\\Client',
        '_PhpScoperf18a0c41e2d2\\Cake\\Model\\ConnectionManager' => '_PhpScoperf18a0c41e2d2\\Cake\\Database\\ConnectionManager',
        '_PhpScoperf18a0c41e2d2\\Cake\\TestSuite\\CakeTestCase' => '_PhpScoperf18a0c41e2d2\\Cake\\TestSuite\\TestCase',
        '_PhpScoperf18a0c41e2d2\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => '_PhpScoperf18a0c41e2d2\\Cake\\TestSuite\\Fixture\\TestFixture',
        '_PhpScoperf18a0c41e2d2\\Cake\\Utility\\String' => '_PhpScoperf18a0c41e2d2\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        '_PhpScoperf18a0c41e2d2\\Cake\\Configure\\PhpReader' => '_PhpScoperf18a0c41e2d2\\Cake\\Core\\Configure\\EnginePhpConfig',
        '_PhpScoperf18a0c41e2d2\\Cake\\Configure\\IniReader' => '_PhpScoperf18a0c41e2d2\\Cake\\Core\\Configure\\EngineIniConfig',
        '_PhpScoperf18a0c41e2d2\\Cake\\Configure\\ConfigReaderInterface' => '_PhpScoperf18a0c41e2d2\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => '_PhpScoperf18a0c41e2d2\\Cake\\Network\\Request',
    ]]]);
};
