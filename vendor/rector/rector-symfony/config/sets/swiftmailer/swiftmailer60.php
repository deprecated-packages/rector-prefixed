<?php

declare (strict_types=1);
namespace RectorPrefix20210421;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20210421\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210421\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # swiftmailer 60
        'Swift_Mime_Message' => 'Swift_Mime_SimpleMessage',
    ]]]);
};
