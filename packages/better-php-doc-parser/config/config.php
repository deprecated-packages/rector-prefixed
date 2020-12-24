<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Doctrine\Common\Annotations\Reader;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser;
use _PhpScoperb75b35f52b74\Rector\DoctrineAnnotationGenerated\ConstantPreservingAnnotationReader;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\BetterPhpDocParser\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject', __DIR__ . '/../src/*/*Info.php', __DIR__ . '/../src/*Info.php', __DIR__ . '/../src/Attributes/Ast/PhpDoc', __DIR__ . '/../src/PhpDocNode']);
    $services->set(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->alias(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\PhpDocParser::class, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser::class);
    $services->alias(\_PhpScoperb75b35f52b74\Doctrine\Common\Annotations\Reader::class, \_PhpScoperb75b35f52b74\Rector\DoctrineAnnotationGenerated\ConstantPreservingAnnotationReader::class);
};
