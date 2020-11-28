<?php

namespace _PhpScoperabd03f0baf05;

use Rector\Compiler\Renaming\JetbrainsStubsRenamer;
use Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use Symplify\SmartFileSystem\SmartFileSystem;
require __DIR__ . '/../vendor/autoload.php';
$symfonyStyleFactory = new \Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory();
$symfonyStyle = $symfonyStyleFactory->create();
$jetbrainsStubsRenamer = new \Rector\Compiler\Renaming\JetbrainsStubsRenamer($symfonyStyle, new \Symplify\SmartFileSystem\SmartFileSystem());
$jetbrainsStubsRenamer->renamePhpStormStubs(__DIR__ . '/../vendor/jetbrains/phpstorm-stubs');
