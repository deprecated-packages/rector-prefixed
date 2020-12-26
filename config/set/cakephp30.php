<?php

declare (strict_types=1);
namespace RectorPrefix20201226;

use Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector;
use Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20201226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # @see https://github.com/cakephp/upgrade/tree/master/src/Shell/Task
    $services->set(\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector::class);
    $services->set(\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # see https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/RenameClassesTask.php#L37
        'RectorPrefix20201226\\Cake\\Network\\Http\\HttpSocket' => 'RectorPrefix20201226\\Cake\\Network\\Http\\Client',
        'RectorPrefix20201226\\Cake\\Model\\ConnectionManager' => 'RectorPrefix20201226\\Cake\\Database\\ConnectionManager',
        'RectorPrefix20201226\\Cake\\TestSuite\\CakeTestCase' => 'RectorPrefix20201226\\Cake\\TestSuite\\TestCase',
        'RectorPrefix20201226\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => 'RectorPrefix20201226\\Cake\\TestSuite\\Fixture\\TestFixture',
        'RectorPrefix20201226\\Cake\\Utility\\String' => 'RectorPrefix20201226\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        'RectorPrefix20201226\\Cake\\Configure\\PhpReader' => 'RectorPrefix20201226\\Cake\\Core\\Configure\\EnginePhpConfig',
        'RectorPrefix20201226\\Cake\\Configure\\IniReader' => 'RectorPrefix20201226\\Cake\\Core\\Configure\\EngineIniConfig',
        'RectorPrefix20201226\\Cake\\Configure\\ConfigReaderInterface' => 'RectorPrefix20201226\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => 'RectorPrefix20201226\\Cake\\Network\\Request',
    ]]]);
};
