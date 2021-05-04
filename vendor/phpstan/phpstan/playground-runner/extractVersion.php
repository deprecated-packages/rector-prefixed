<?php

declare (strict_types=1);
namespace RectorPrefix20210504;

require 'phar://' . __DIR__ . '/vendor/phpstan/phpstan/phpstan.phar/vendor/composer/InstalledVersions.php';
echo \RectorPrefix20210504\Composer\InstalledVersions::getReference('phpstan/phpstan-src');
