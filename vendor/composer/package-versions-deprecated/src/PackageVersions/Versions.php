<?php

declare (strict_types=1);
namespace _PhpScoper5edc98a7cce2\PackageVersions;

use _PhpScoper5edc98a7cce2\Composer\InstalledVersions;
use OutOfBoundsException;
\class_exists(\_PhpScoper5edc98a7cce2\Composer\InstalledVersions::class);
/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'rector/rector';
    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS = array('composer/package-versions-deprecated' => '1.11.99.1@7413f0b55a051e89485c5cb9f765fe24bb02a7b6', 'composer/xdebug-handler' => '1.4.5@f28d44c286812c714741478d968104c5e604a1d4', 'doctrine/annotations' => '1.11.1@ce77a7ba1770462cd705a91a151b6c3746f9c6ad', 'doctrine/inflector' => '2.0.3@9cf661f4eb38f7c881cac67c75ea9b00bf97b210', 'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042', 'jean85/pretty-package-versions' => '1.5.1@a917488320c20057da87f67d0d40543dd9427f7a', 'nette/finder' => 'v2.5.2@4ad2c298eb8c687dd0e74ae84206a4186eeaed50', 'nette/neon' => 'v3.2.1@a5b3a60833d2ef55283a82d0c30b45d136b29e75', 'nette/robot-loader' => 'v3.3.1@15c1ecd0e6e69e8d908dfc4cca7b14f3b850a96b', 'nette/utils' => 'v3.2.0@d0427c1811462dbb6c503143eabe5478b26685f7', 'nikic/php-parser' => 'v4.10.4@c6d052fc58cb876152f89f532b95a8d7907e7f0e', 'phpstan/phpdoc-parser' => '0.4.10@5c1eb9aac80cb236f1b7fbe52e691afe4cc9f430', 'phpstan/phpstan' => '0.12.64@23eb1cb7ae125f45f1d0e48051bcf67a9a9b08aa', 'phpstan/phpstan-phpunit' => '0.12.17@432575b41cf2d4f44e460234acaf56119ed97d36', 'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8', 'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f', 'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0', 'psr/log' => '1.1.3@0f73288fd15629204f9d42b7055f72dacbe811fc', 'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b', 'sebastian/diff' => '4.0.4@3461e3fccc7cfdfc2720be910d3bd73c69be590d', 'symfony/cache' => 'v5.2.1@5e61d63b1ef4fb4852994038267ad45e12f3ec52', 'symfony/cache-contracts' => 'v2.2.0@8034ca0b61d4dd967f3698aaa1da2507b631d0cb', 'symfony/config' => 'v5.2.1@d0a82d965296083fe463d655a3644cbe49cbaa80', 'symfony/console' => 'v5.2.1@47c02526c532fb381374dab26df05e7313978976', 'symfony/dependency-injection' => 'v5.2.1@7f8a9e9eff0581a33e20f6c5d41096fe22832d25', 'symfony/deprecation-contracts' => 'v2.2.0@5fa56b4074d1ae755beb55617ddafe6f5d78f665', 'symfony/error-handler' => 'v5.2.1@59b190ce16ddf32771a22087b60f6dafd3407147', 'symfony/event-dispatcher' => 'v5.2.1@1c93f7a1dff592c252574c79a8635a8a80856042', 'symfony/event-dispatcher-contracts' => 'v2.2.0@0ba7d54483095a198fa51781bc608d17e84dffa2', 'symfony/filesystem' => 'v5.2.1@fa8f8cab6b65e2d99a118e082935344c5ba8c60d', 'symfony/finder' => 'v5.2.1@0b9231a5922fd7287ba5b411893c0ecd2733e5ba', 'symfony/http-client-contracts' => 'v2.3.1@41db680a15018f9c1d4b23516059633ce280ca33', 'symfony/http-foundation' => 'v5.2.1@a1f6218b29897ab52acba58cfa905b83625bef8d', 'symfony/http-kernel' => 'v5.2.1@1feb619286d819180f7b8bc0dc44f516d9c62647', 'symfony/polyfill-ctype' => 'v1.20.0@f4ba089a5b6366e453971d3aad5fe8e897b37f41', 'symfony/polyfill-intl-grapheme' => 'v1.20.0@c7cf3f858ec7d70b89559d6e6eb1f7c2517d479c', 'symfony/polyfill-intl-normalizer' => 'v1.20.0@727d1096295d807c309fb01a851577302394c897', 'symfony/polyfill-mbstring' => 'v1.20.0@39d483bdf39be819deabf04ec872eb0b2410b531', 'symfony/polyfill-php73' => 'v1.20.0@8ff431c517be11c78c48a39a66d37431e26a6bed', 'symfony/polyfill-php80' => 'v1.20.0@e70aa8b064c5b72d3df2abd5ab1e90464ad009de', 'symfony/service-contracts' => 'v2.2.0@d15da7ba4957ffb8f1747218be9e1a121fd298a1', 'symfony/string' => 'v5.2.1@5bd67751d2e3f7d6f770c9154b8fbcb2aa05f7ed', 'symfony/var-dumper' => 'v5.2.1@13e7e882eaa55863faa7c4ad7c60f12f1a8b5089', 'symfony/var-exporter' => 'v5.2.1@fbc3507f23d263d75417e09a12d77c009f39676c', 'symfony/yaml' => 'v5.2.1@290ea5e03b8cf9b42c783163123f54441fb06939', 'symplify/autowire-array-parameter' => '9.0.17@7f148f3dcb426e14f3391f49540a47e8101dceb3', 'symplify/composer-json-manipulator' => '9.0.17@80a46f739bbde10dbcd06d1bea3f7f4f295c6590', 'symplify/console-color-diff' => '9.0.17@004d717a31c2f602d103ba2201b832ece2dbf2d1', 'symplify/easy-testing' => '9.0.17@789a662fedfaa5151ec9dc25e058b105f343c010', 'symplify/markdown-diff' => '9.0.17@2dc25621f0d00c071045f567226d8d800547cf75', 'symplify/package-builder' => '9.0.17@b4bbcaba5f17f084dbce026e2db740cdabe040c5', 'symplify/php-config-printer' => '9.0.17@ea07dc6768955ffce66ad985b85418d5b9dc5307', 'symplify/rule-doc-generator' => '9.0.17@747ef90a7f6502bbb2faa7d4937a195cd343da35', 'symplify/set-config-resolver' => '9.0.17@b32e375343fe78164e85040f2791857171b124c0', 'symplify/simple-php-doc-parser' => '9.0.17@24aab2aade53a895a343af22077255cdf6577ca5', 'symplify/skipper' => '9.0.17@530bce2c49beb398cba9cadd421c6a19c3f6ea3b', 'symplify/smart-file-system' => '9.0.17@7f0b4af8ebc9dea9d15073259bcb40a079b52970', 'symplify/symfony-php-config' => '9.0.17@e450fccdfaa788a7aae76e568afaa223dcd06c13', 'symplify/symplify-kernel' => '9.0.17@b6342f0fe30032e6924c9569353c79293a3fb036', 'webmozart/assert' => '1.9.1@bafc69caeb4d49c39fd0779086c03a3738cbb389', 'rector/rector-prefixed' => 'dev-69cbc609f824560b565b3779ab5c18f929519e7f@69cbc609f824560b565b3779ab5c18f929519e7f', 'rector/rector' => 'dev-69cbc609f824560b565b3779ab5c18f929519e7f@69cbc609f824560b565b3779ab5c18f929519e7f');
    private function __construct()
    {
    }
    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!\class_exists(\_PhpScoper5edc98a7cce2\Composer\InstalledVersions::class, \false) || !\_PhpScoper5edc98a7cce2\Composer\InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }
        return \_PhpScoper5edc98a7cce2\Composer\InstalledVersions::getRootPackage()['name'];
    }
    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName) : string
    {
        if (\class_exists(\_PhpScoper5edc98a7cce2\Composer\InstalledVersions::class, \false) && \_PhpScoper5edc98a7cce2\Composer\InstalledVersions::getRawData()) {
            return \_PhpScoper5edc98a7cce2\Composer\InstalledVersions::getPrettyVersion($packageName) . '@' . \_PhpScoper5edc98a7cce2\Composer\InstalledVersions::getReference($packageName);
        }
        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }
        throw new \OutOfBoundsException('Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files');
    }
}
