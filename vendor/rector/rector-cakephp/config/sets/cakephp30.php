<?php

declare (strict_types=1);
namespace RectorPrefix20210321;

use Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector;
use Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # @see https://github.com/cakephp/upgrade/tree/master/src/Shell/Task
    $services->set(\Rector\CakePHP\Rector\Namespace_\AppUsesStaticCallToUseStatementRector::class);
    $services->set(\Rector\CakePHP\Rector\FileWithoutNamespace\ImplicitShortClassNameUseStatementRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # see https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/RenameClassesTask.php#L37
        'RectorPrefix20210321\\Cake\\Network\\Http\\HttpSocket' => 'RectorPrefix20210321\\Cake\\Network\\Http\\Client',
        'RectorPrefix20210321\\Cake\\Model\\ConnectionManager' => 'RectorPrefix20210321\\Cake\\Database\\ConnectionManager',
        'RectorPrefix20210321\\Cake\\TestSuite\\CakeTestCase' => 'RectorPrefix20210321\\Cake\\TestSuite\\TestCase',
        'RectorPrefix20210321\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => 'RectorPrefix20210321\\Cake\\TestSuite\\Fixture\\TestFixture',
        'RectorPrefix20210321\\Cake\\Utility\\String' => 'RectorPrefix20210321\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        'RectorPrefix20210321\\Cake\\Configure\\PhpReader' => 'RectorPrefix20210321\\Cake\\Core\\Configure\\EnginePhpConfig',
        'RectorPrefix20210321\\Cake\\Configure\\IniReader' => 'RectorPrefix20210321\\Cake\\Core\\Configure\\EngineIniConfig',
        'RectorPrefix20210321\\Cake\\Configure\\ConfigReaderInterface' => 'RectorPrefix20210321\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => 'RectorPrefix20210321\\Cake\\Network\\Request',
    ]]]);
};
