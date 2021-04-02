<?php

declare (strict_types=1);
namespace RectorPrefix20210402;

use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TypeParser;
use RectorPrefix20210402\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210402\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('RectorPrefix20210402\Symplify\\SimplePhpDocParser\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
    $services->set(\PHPStan\PhpDocParser\Parser\PhpDocParser::class);
    $services->set(\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->set(\PHPStan\PhpDocParser\Parser\TypeParser::class);
    $services->set(\PHPStan\PhpDocParser\Parser\ConstExprParser::class);
};
