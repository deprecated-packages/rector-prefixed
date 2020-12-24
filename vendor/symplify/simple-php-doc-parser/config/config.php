<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\ConstExprParser;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TypeParser;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\SimplePhpDocParser\\', __DIR__ . '/../src');
    $services->set(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser::class);
    $services->set(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->set(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TypeParser::class);
    $services->set(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\ConstExprParser::class);
};
