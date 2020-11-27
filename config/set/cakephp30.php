<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

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
        '_PhpScoper26e51eeacccf\\Cake\\Network\\Http\\HttpSocket' => '_PhpScoper26e51eeacccf\\Cake\\Network\\Http\\Client',
        '_PhpScoper26e51eeacccf\\Cake\\Model\\ConnectionManager' => '_PhpScoper26e51eeacccf\\Cake\\Database\\ConnectionManager',
        '_PhpScoper26e51eeacccf\\Cake\\TestSuite\\CakeTestCase' => '_PhpScoper26e51eeacccf\\Cake\\TestSuite\\TestCase',
        '_PhpScoper26e51eeacccf\\Cake\\TestSuite\\Fixture\\CakeTestFixture' => '_PhpScoper26e51eeacccf\\Cake\\TestSuite\\Fixture\\TestFixture',
        '_PhpScoper26e51eeacccf\\Cake\\Utility\\String' => '_PhpScoper26e51eeacccf\\Cake\\Utility\\Text',
        'CakePlugin' => 'Plugin',
        'CakeException' => 'Exception',
        # see https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#configure
        '_PhpScoper26e51eeacccf\\Cake\\Configure\\PhpReader' => '_PhpScoper26e51eeacccf\\Cake\\Core\\Configure\\EnginePhpConfig',
        '_PhpScoper26e51eeacccf\\Cake\\Configure\\IniReader' => '_PhpScoper26e51eeacccf\\Cake\\Core\\Configure\\EngineIniConfig',
        '_PhpScoper26e51eeacccf\\Cake\\Configure\\ConfigReaderInterface' => '_PhpScoper26e51eeacccf\\Cake\\Core\\Configure\\ConfigEngineInterface',
        # https://book.cakephp.org/3/en/appendices/3-0-migration-guide.html#request
        'CakeRequest' => '_PhpScoper26e51eeacccf\\Cake\\Network\\Request',
    ]]]);
};
