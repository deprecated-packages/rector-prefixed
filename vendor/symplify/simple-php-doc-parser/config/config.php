<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TypeParser;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\SimplePhpDocParser\\', __DIR__ . '/../src');
    $services->set(\PHPStan\PhpDocParser\Parser\PhpDocParser::class);
    $services->set(\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->set(\PHPStan\PhpDocParser\Parser\TypeParser::class);
    $services->set(\PHPStan\PhpDocParser\Parser\ConstExprParser::class);
};
