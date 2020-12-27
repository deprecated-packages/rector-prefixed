<?php

declare (strict_types=1);
namespace RectorPrefix20201227;

use RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\ConstExprParser;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\PhpDocParser;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TypeParser;
use RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('RectorPrefix20201227\Symplify\\SimplePhpDocParser\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
    $services->set(\RectorPrefix20201227\PHPStan\PhpDocParser\Parser\PhpDocParser::class);
    $services->set(\RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->set(\RectorPrefix20201227\PHPStan\PhpDocParser\Parser\TypeParser::class);
    $services->set(\RectorPrefix20201227\PHPStan\PhpDocParser\Parser\ConstExprParser::class);
};
