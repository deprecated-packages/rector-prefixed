<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\ConstExprParser;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TypeParser;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\SimplePhpDocParser\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\PhpDocParser::class);
    $services->set(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->set(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TypeParser::class);
    $services->set(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\ConstExprParser::class);
};
