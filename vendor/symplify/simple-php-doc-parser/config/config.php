<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\ConstExprParser;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TypeParser;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\SimplePhpDocParser\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\PhpDocParser::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\TypeParser::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\ConstExprParser::class);
};
