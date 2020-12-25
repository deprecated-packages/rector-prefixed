<?php

namespace _PhpScoper5b8c9e9ebd21\Composer;

use _PhpScoper5b8c9e9ebd21\Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => 'dev-f7b02883e2fba9ee46f21a32cb3edc7a90120738', 'version' => 'dev-f7b02883e2fba9ee46f21a32cb3edc7a90120738', 'aliases' => array(), 'reference' => 'f7b02883e2fba9ee46f21a32cb3edc7a90120738', 'name' => 'rector/rector'), 'versions' => array('composer/package-versions-deprecated' => array('pretty_version' => '1.11.99.1', 'version' => '1.11.99.1', 'aliases' => array(), 'reference' => '7413f0b55a051e89485c5cb9f765fe24bb02a7b6'), 'composer/xdebug-handler' => array('pretty_version' => '1.4.5', 'version' => '1.4.5.0', 'aliases' => array(), 'reference' => 'f28d44c286812c714741478d968104c5e604a1d4'), 'doctrine/annotations' => array('pretty_version' => '1.11.1', 'version' => '1.11.1.0', 'aliases' => array(), 'reference' => 'ce77a7ba1770462cd705a91a151b6c3746f9c6ad'), 'doctrine/inflector' => array('pretty_version' => '2.0.3', 'version' => '2.0.3.0', 'aliases' => array(), 'reference' => '9cf661f4eb38f7c881cac67c75ea9b00bf97b210'), 'doctrine/lexer' => array('pretty_version' => '1.2.1', 'version' => '1.2.1.0', 'aliases' => array(), 'reference' => 'e864bbf5904cb8f5bb334f99209b48018522f042'), 'jean85/pretty-package-versions' => array('pretty_version' => '1.5.1', 'version' => '1.5.1.0', 'aliases' => array(), 'reference' => 'a917488320c20057da87f67d0d40543dd9427f7a'), 'nette/finder' => array('pretty_version' => 'v2.5.2', 'version' => '2.5.2.0', 'aliases' => array(), 'reference' => '4ad2c298eb8c687dd0e74ae84206a4186eeaed50'), 'nette/neon' => array('pretty_version' => 'v3.2.1', 'version' => '3.2.1.0', 'aliases' => array(), 'reference' => 'a5b3a60833d2ef55283a82d0c30b45d136b29e75'), 'nette/robot-loader' => array('pretty_version' => 'v3.3.1', 'version' => '3.3.1.0', 'aliases' => array(), 'reference' => '15c1ecd0e6e69e8d908dfc4cca7b14f3b850a96b'), 'nette/utils' => array('pretty_version' => 'v3.2.0', 'version' => '3.2.0.0', 'aliases' => array(), 'reference' => 'd0427c1811462dbb6c503143eabe5478b26685f7'), 'nikic/php-parser' => array('pretty_version' => 'v4.10.4', 'version' => '4.10.4.0', 'aliases' => array(), 'reference' => 'c6d052fc58cb876152f89f532b95a8d7907e7f0e'), 'ocramius/package-versions' => array('replaced' => array(0 => '1.11.99')), 'phpstan/phpdoc-parser' => array('pretty_version' => '0.4.10', 'version' => '0.4.10.0', 'aliases' => array(), 'reference' => '5c1eb9aac80cb236f1b7fbe52e691afe4cc9f430'), 'phpstan/phpstan' => array('pretty_version' => '0.12.64', 'version' => '0.12.64.0', 'aliases' => array(), 'reference' => '23eb1cb7ae125f45f1d0e48051bcf67a9a9b08aa'), 'phpstan/phpstan-phpunit' => array('pretty_version' => '0.12.17', 'version' => '0.12.17.0', 'aliases' => array(), 'reference' => '432575b41cf2d4f44e460234acaf56119ed97d36'), 'psr/cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => 'd11b50ad223250cf17b86e38383413f5a6764bf8'), 'psr/cache-implementation' => array('provided' => array(0 => '1.0')), 'psr/container' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'b7ce3b176482dbbc1245ebf52b181af44c2cf55f'), 'psr/container-implementation' => array('provided' => array(0 => '1.0')), 'psr/event-dispatcher' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0'), 'psr/event-dispatcher-implementation' => array('provided' => array(0 => '1.0')), 'psr/log' => array('pretty_version' => '1.1.3', 'version' => '1.1.3.0', 'aliases' => array(), 'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc'), 'psr/log-implementation' => array('provided' => array(0 => '1.0')), 'psr/simple-cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b'), 'psr/simple-cache-implementation' => array('provided' => array(0 => '1.0')), 'rector/rector' => array('pretty_version' => 'dev-f7b02883e2fba9ee46f21a32cb3edc7a90120738', 'version' => 'dev-f7b02883e2fba9ee46f21a32cb3edc7a90120738', 'aliases' => array(), 'reference' => 'f7b02883e2fba9ee46f21a32cb3edc7a90120738'), 'rector/rector-prefixed' => array('replaced' => array(0 => 'dev-f7b02883e2fba9ee46f21a32cb3edc7a90120738')), 'sebastian/diff' => array('pretty_version' => '4.0.4', 'version' => '4.0.4.0', 'aliases' => array(), 'reference' => '3461e3fccc7cfdfc2720be910d3bd73c69be590d'), 'symfony/cache' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '5e61d63b1ef4fb4852994038267ad45e12f3ec52'), 'symfony/cache-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '8034ca0b61d4dd967f3698aaa1da2507b631d0cb'), 'symfony/cache-implementation' => array('provided' => array(0 => '1.0')), 'symfony/config' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => 'd0a82d965296083fe463d655a3644cbe49cbaa80'), 'symfony/console' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '47c02526c532fb381374dab26df05e7313978976'), 'symfony/dependency-injection' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '7f8a9e9eff0581a33e20f6c5d41096fe22832d25'), 'symfony/deprecation-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '5fa56b4074d1ae755beb55617ddafe6f5d78f665'), 'symfony/error-handler' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '59b190ce16ddf32771a22087b60f6dafd3407147'), 'symfony/event-dispatcher' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '1c93f7a1dff592c252574c79a8635a8a80856042'), 'symfony/event-dispatcher-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '0ba7d54483095a198fa51781bc608d17e84dffa2'), 'symfony/event-dispatcher-implementation' => array('provided' => array(0 => '2.0')), 'symfony/filesystem' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => 'fa8f8cab6b65e2d99a118e082935344c5ba8c60d'), 'symfony/finder' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '0b9231a5922fd7287ba5b411893c0ecd2733e5ba'), 'symfony/http-client-contracts' => array('pretty_version' => 'v2.3.1', 'version' => '2.3.1.0', 'aliases' => array(), 'reference' => '41db680a15018f9c1d4b23516059633ce280ca33'), 'symfony/http-foundation' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => 'a1f6218b29897ab52acba58cfa905b83625bef8d'), 'symfony/http-kernel' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '1feb619286d819180f7b8bc0dc44f516d9c62647'), 'symfony/polyfill-ctype' => array('pretty_version' => 'v1.20.0', 'version' => '1.20.0.0', 'aliases' => array(), 'reference' => 'f4ba089a5b6366e453971d3aad5fe8e897b37f41'), 'symfony/polyfill-intl-grapheme' => array('pretty_version' => 'v1.20.0', 'version' => '1.20.0.0', 'aliases' => array(), 'reference' => 'c7cf3f858ec7d70b89559d6e6eb1f7c2517d479c'), 'symfony/polyfill-intl-normalizer' => array('pretty_version' => 'v1.20.0', 'version' => '1.20.0.0', 'aliases' => array(), 'reference' => '727d1096295d807c309fb01a851577302394c897'), 'symfony/polyfill-mbstring' => array('pretty_version' => 'v1.20.0', 'version' => '1.20.0.0', 'aliases' => array(), 'reference' => '39d483bdf39be819deabf04ec872eb0b2410b531'), 'symfony/polyfill-php73' => array('pretty_version' => 'v1.20.0', 'version' => '1.20.0.0', 'aliases' => array(), 'reference' => '8ff431c517be11c78c48a39a66d37431e26a6bed'), 'symfony/polyfill-php80' => array('pretty_version' => 'v1.20.0', 'version' => '1.20.0.0', 'aliases' => array(), 'reference' => 'e70aa8b064c5b72d3df2abd5ab1e90464ad009de'), 'symfony/service-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => 'd15da7ba4957ffb8f1747218be9e1a121fd298a1'), 'symfony/service-implementation' => array('provided' => array(0 => '1.0')), 'symfony/string' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '5bd67751d2e3f7d6f770c9154b8fbcb2aa05f7ed'), 'symfony/var-dumper' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '13e7e882eaa55863faa7c4ad7c60f12f1a8b5089'), 'symfony/var-exporter' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => 'fbc3507f23d263d75417e09a12d77c009f39676c'), 'symfony/yaml' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '290ea5e03b8cf9b42c783163123f54441fb06939'), 'symplify/autowire-array-parameter' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => '89a4cffaf6bc6f2f62f09f4dca25aa2766273451'), 'symplify/composer-json-manipulator' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => '3c9d21656f7d8c1da42212509d9dc8ec63f4efe5'), 'symplify/console-color-diff' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => '75750fcc53482febae6959f2115d19784d235d38'), 'symplify/easy-testing' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => '6d0707ad2d410b2507d353e307a9961ceb92c6e1'), 'symplify/markdown-diff' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => '776cc9f79786d291812eac9e5b11ec2529dc11d0'), 'symplify/package-builder' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => 'b1978df29d3ca9c22a41b687c181e1826a96194a'), 'symplify/php-config-printer' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => 'b7d72c2b3d9f4b7818d26c2c6aec46b49e04abf7'), 'symplify/rule-doc-generator' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => 'dfaa60161eeb654c195e5f4c85967066e2d57809'), 'symplify/set-config-resolver' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => '9e65b0b6263d11908cb8017e31d11cf3baaa6a1e'), 'symplify/simple-php-doc-parser' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => '3241cde036b706c76713b69fe901bf674ce1610b'), 'symplify/skipper' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => 'c62be135664875b3d3d7a214f2fdfe03ea85969c'), 'symplify/smart-file-system' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => '7f0b4af8ebc9dea9d15073259bcb40a079b52970'), 'symplify/symfony-php-config' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => '4ec1f086e64f99df451438e0d63b99c29583c0f2'), 'symplify/symplify-kernel' => array('pretty_version' => '9.0.16', 'version' => '9.0.16.0', 'aliases' => array(), 'reference' => 'f1a4cb0b02ff25e394ed0fa479768510ad2a775e'), 'webmozart/assert' => array('pretty_version' => '1.9.1', 'version' => '1.9.1.0', 'aliases' => array(), 'reference' => 'bafc69caeb4d49c39fd0779086c03a3738cbb389')));
    public static function getInstalledPackages()
    {
        return \array_keys(self::$installed['versions']);
    }
    public static function isInstalled($packageName)
    {
        return isset(self::$installed['versions'][$packageName]);
    }
    public static function satisfies(\_PhpScoper5b8c9e9ebd21\Composer\Semver\VersionParser $parser, $packageName, $constraint)
    {
        $constraint = $parser->parseConstraints($constraint);
        $provided = $parser->parseConstraints(self::getVersionRanges($packageName));
        return $provided->matches($constraint);
    }
    public static function getVersionRanges($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        $ranges = array();
        if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            $ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
        }
        if (\array_key_exists('aliases', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
        }
        if (\array_key_exists('replaced', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
        }
        if (\array_key_exists('provided', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
        }
        return \implode(' || ', $ranges);
    }
    public static function getVersion($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['version'];
    }
    public static function getPrettyVersion($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['pretty_version'];
    }
    public static function getReference($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['reference'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['reference'];
    }
    public static function getRootPackage()
    {
        return self::$installed['root'];
    }
    public static function getRawData()
    {
        return self::$installed;
    }
    public static function reload($data)
    {
        self::$installed = $data;
    }
}
