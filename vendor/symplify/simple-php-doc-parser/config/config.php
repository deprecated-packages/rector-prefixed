<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\ConstExprParser;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TypeParser;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\SimplePhpDocParser\\', __DIR__ . '/../src');
    $services->set(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\PhpDocParser::class);
    $services->set(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->set(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\TypeParser::class);
    $services->set(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\ConstExprParser::class);
};
