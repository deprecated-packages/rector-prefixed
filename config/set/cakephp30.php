<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector;
use Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # @see https://github.com/cakephp/upgrade/tree/master/src/Shell/Task
    $services->set(\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector::class);
    $services->set(\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # see https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/RenameClassesTask.php#L37
        'RectorPrefix2020DecSat\\Cake\\Network\\Http\\HttpSocket' => 'RectorPrefix2020DecSat\\Cake\\Network\\Http\\Client',
        'RectorPrefix2020DecSat\\Cake\\Model\\ConnectionManager' => 'RectorPrefix2020DecSat\\Cake\\Database\\ConnectionManager',
        'RectorPrefix2020DecSat\\Cake\\TestSuite\\CakeTestCase' => 'RectorPrefix2020DecSat\\Cake\\TestSuite\\TestCase',
        'RectorPrefix2020DecSat\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => 'RectorPrefix2020DecSat\\Cake\\TestSuite\\Fixture\\TestFixture',
        'RectorPrefix2020DecSat\\Cake\\Utility\\String' => 'RectorPrefix2020DecSat\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        'RectorPrefix2020DecSat\\Cake\\Configure\\PhpReader' => 'RectorPrefix2020DecSat\\Cake\\Core\\Configure\\EnginePhpConfig',
        'RectorPrefix2020DecSat\\Cake\\Configure\\IniReader' => 'RectorPrefix2020DecSat\\Cake\\Core\\Configure\\EngineIniConfig',
        'RectorPrefix2020DecSat\\Cake\\Configure\\ConfigReaderInterface' => 'RectorPrefix2020DecSat\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => 'RectorPrefix2020DecSat\\Cake\\Network\\Request',
    ]]]);
};
