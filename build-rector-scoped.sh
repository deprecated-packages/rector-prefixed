# local-prefix test

# repace phpstan/phpstan with phpstan/phpstan-src
composer remove phpstan/phpstan --no-update
composer config repositories.repo-name vcs https://github.com/phpstan/phpstan-src.git
composer require phpstan/phpstan-src:@dev --no-update

composer require jetbrains/phpstorm-stubs:dev-master#05d145c0bbafcf9a551fdd8824adb2a7e259fdaf --no-update
composer update --no-progress --ansi

bin/rector process vendor/phpstan/phpstan-src/src --config ci/downgrade-phpstan-php74-rector.php --ansi

rsync -av * nested-rector

composer update --working-dir nested-rector --no-dev --prefer-dist --ansi

wget https://github.com/humbug/php-scoper/releases/download/0.13.9/php-scoper.phar


cd nested-rector && php ../php-scoper.phar add-prefix . --output-dir ../rector-scoped --config scoper.inc.php --force --ansi -vvv
cd ..

# @todo update vendor/composer/platform_check.php version

composer config platform.php 7.2 --working-dir rector-scoped

bin/rector process rector-scoped/vendor/composer/platform_check.php --config ci/downgrade-php71-rector-scoped.php

composer dump-autoload --working-dir rector-scoped --ansi --optimize --classmap-authoritative

vendor/bin/package-scoper scope-composer-json rector-scoped/composer.json --ansi

rm rector-scoped/phpstan.neon
