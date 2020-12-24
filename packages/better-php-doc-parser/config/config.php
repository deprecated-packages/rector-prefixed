<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Doctrine\Common\Annotations\Reader;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser;
use _PhpScopere8e811afab72\Rector\DoctrineAnnotationGenerated\ConstantPreservingAnnotationReader;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\BetterPhpDocParser\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject', __DIR__ . '/../src/*/*Info.php', __DIR__ . '/../src/*Info.php', __DIR__ . '/../src/Attributes/Ast/PhpDoc', __DIR__ . '/../src/PhpDocNode']);
    $services->set(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->alias(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser::class, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser::class);
    $services->alias(\_PhpScopere8e811afab72\Doctrine\Common\Annotations\Reader::class, \_PhpScopere8e811afab72\Rector\DoctrineAnnotationGenerated\ConstantPreservingAnnotationReader::class);
};
