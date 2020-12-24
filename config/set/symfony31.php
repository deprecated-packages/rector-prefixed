<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT_FOR_MAP'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::PARSE_OBJECT'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \true, 'Symfony\\Component\\Yaml\\Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'parse', 1, \false, 0), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, [\false, \true], 'Symfony\\Component\\Yaml\\Yaml::DUMP_OBJECT'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml', 'dump', 3, \true, 'Symfony\\Component\\Yaml\\Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE')])]]);
};
