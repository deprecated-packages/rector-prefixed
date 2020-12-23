<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\ConstExprParser;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\TypeParser;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\SimplePhpDocParser\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\PhpDocParser::class);
    $services->set(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->set(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\TypeParser::class);
    $services->set(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\ConstExprParser::class);
};
