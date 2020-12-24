<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Doctrine\Common\Annotations\Reader;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser;
use _PhpScoper0a6b37af0871\Rector\DoctrineAnnotationGenerated\ConstantPreservingAnnotationReader;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\BetterPhpDocParser\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject', __DIR__ . '/../src/*/*Info.php', __DIR__ . '/../src/*Info.php', __DIR__ . '/../src/Attributes/Ast/PhpDoc', __DIR__ . '/../src/PhpDocNode']);
    $services->set(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->alias(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\PhpDocParser::class, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser::class);
    $services->alias(\_PhpScoper0a6b37af0871\Doctrine\Common\Annotations\Reader::class, \_PhpScoper0a6b37af0871\Rector\DoctrineAnnotationGenerated\ConstantPreservingAnnotationReader::class);
};
