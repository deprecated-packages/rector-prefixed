<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726;

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
        '_PhpScoper17db12703726\\Cake\\Network\\Http\\HttpSocket' => '_PhpScoper17db12703726\\Cake\\Network\\Http\\Client',
        '_PhpScoper17db12703726\\Cake\\Model\\ConnectionManager' => '_PhpScoper17db12703726\\Cake\\Database\\ConnectionManager',
        '_PhpScoper17db12703726\\Cake\\TestSuite\\CakeTestCase' => '_PhpScoper17db12703726\\Cake\\TestSuite\\TestCase',
        '_PhpScoper17db12703726\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => '_PhpScoper17db12703726\\Cake\\TestSuite\\Fixture\\TestFixture',
        '_PhpScoper17db12703726\\Cake\\Utility\\String' => '_PhpScoper17db12703726\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        '_PhpScoper17db12703726\\Cake\\Configure\\PhpReader' => '_PhpScoper17db12703726\\Cake\\Core\\Configure\\EnginePhpConfig',
        '_PhpScoper17db12703726\\Cake\\Configure\\IniReader' => '_PhpScoper17db12703726\\Cake\\Core\\Configure\\EngineIniConfig',
        '_PhpScoper17db12703726\\Cake\\Configure\\ConfigReaderInterface' => '_PhpScoper17db12703726\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => '_PhpScoper17db12703726\\Cake\\Network\\Request',
    ]]]);
};
