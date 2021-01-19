<?php

namespace RectorPrefix20210119\Composer;

use RectorPrefix20210119\Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => '66d0b61a9d5bb28e53cbb9cc71621a2a8e940ee6', 'name' => 'rector/rector'), 'versions' => array('composer/package-versions-deprecated' => array('pretty_version' => '1.11.99.1', 'version' => '1.11.99.1', 'aliases' => array(), 'reference' => '7413f0b55a051e89485c5cb9f765fe24bb02a7b6'), 'composer/semver' => array('pretty_version' => '3.2.4', 'version' => '3.2.4.0', 'aliases' => array(), 'reference' => 'a02fdf930a3c1c3ed3a49b5f63859c0c20e10464'), 'composer/xdebug-handler' => array('pretty_version' => '1.4.5', 'version' => '1.4.5.0', 'aliases' => array(), 'reference' => 'f28d44c286812c714741478d968104c5e604a1d4'), 'doctrine/annotations' => array('pretty_version' => '1.11.1', 'version' => '1.11.1.0', 'aliases' => array(), 'reference' => 'ce77a7ba1770462cd705a91a151b6c3746f9c6ad'), 'doctrine/inflector' => array('pretty_version' => '2.0.3', 'version' => '2.0.3.0', 'aliases' => array(), 'reference' => '9cf661f4eb38f7c881cac67c75ea9b00bf97b210'), 'doctrine/lexer' => array('pretty_version' => '1.2.1', 'version' => '1.2.1.0', 'aliases' => array(), 'reference' => 'e864bbf5904cb8f5bb334f99209b48018522f042'), 'jean85/pretty-package-versions' => array('pretty_version' => '1.5.1', 'version' => '1.5.1.0', 'aliases' => array(), 'reference' => 'a917488320c20057da87f67d0d40543dd9427f7a'), 'nette/finder' => array('pretty_version' => 'v2.5.2', 'version' => '2.5.2.0', 'aliases' => array(), 'reference' => '4ad2c298eb8c687dd0e74ae84206a4186eeaed50'), 'nette/neon' => array('pretty_version' => 'v3.2.1', 'version' => '3.2.1.0', 'aliases' => array(), 'reference' => 'a5b3a60833d2ef55283a82d0c30b45d136b29e75'), 'nette/robot-loader' => array('pretty_version' => 'v3.3.1', 'version' => '3.3.1.0', 'aliases' => array(), 'reference' => '15c1ecd0e6e69e8d908dfc4cca7b14f3b850a96b'), 'nette/utils' => array('pretty_version' => 'v3.2.1', 'version' => '3.2.1.0', 'aliases' => array(), 'reference' => '2bc2f58079c920c2ecbb6935645abf6f2f5f94ba'), 'nikic/php-parser' => array('pretty_version' => 'v4.10.4', 'version' => '4.10.4.0', 'aliases' => array(), 'reference' => 'c6d052fc58cb876152f89f532b95a8d7907e7f0e'), 'ocramius/package-versions' => array('replaced' => array(0 => '1.11.99')), 'phpstan/phpdoc-parser' => array('pretty_version' => '0.4.10', 'version' => '0.4.10.0', 'aliases' => array(), 'reference' => '5c1eb9aac80cb236f1b7fbe52e691afe4cc9f430'), 'phpstan/phpstan' => array('pretty_version' => '0.12.68', 'version' => '0.12.68.0', 'aliases' => array(), 'reference' => 'ddbe01af0706ee094c3f1ce9730b35aebb508d3d'), 'phpstan/phpstan-phpunit' => array('pretty_version' => '0.12.17', 'version' => '0.12.17.0', 'aliases' => array(), 'reference' => '432575b41cf2d4f44e460234acaf56119ed97d36'), 'psr/cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => 'd11b50ad223250cf17b86e38383413f5a6764bf8'), 'psr/cache-implementation' => array('provided' => array(0 => '1.0')), 'psr/container' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'b7ce3b176482dbbc1245ebf52b181af44c2cf55f'), 'psr/container-implementation' => array('provided' => array(0 => '1.0')), 'psr/event-dispatcher' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0'), 'psr/event-dispatcher-implementation' => array('provided' => array(0 => '1.0')), 'psr/log' => array('pretty_version' => '1.1.3', 'version' => '1.1.3.0', 'aliases' => array(), 'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc'), 'psr/log-implementation' => array('provided' => array(0 => '1.0')), 'psr/simple-cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b'), 'psr/simple-cache-implementation' => array('provided' => array(0 => '1.0')), 'rector/rector' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => '66d0b61a9d5bb28e53cbb9cc71621a2a8e940ee6'), 'rector/rector-prefixed' => array('replaced' => array(0 => 'dev-master')), 'sebastian/diff' => array('pretty_version' => '4.0.4', 'version' => '4.0.4.0', 'aliases' => array(), 'reference' => '3461e3fccc7cfdfc2720be910d3bd73c69be590d'), 'symfony/cache' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '5e61d63b1ef4fb4852994038267ad45e12f3ec52'), 'symfony/cache-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '8034ca0b61d4dd967f3698aaa1da2507b631d0cb'), 'symfony/cache-implementation' => array('provided' => array(0 => '1.0')), 'symfony/config' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => 'd0a82d965296083fe463d655a3644cbe49cbaa80'), 'symfony/console' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '47c02526c532fb381374dab26df05e7313978976'), 'symfony/dependency-injection' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '7f8a9e9eff0581a33e20f6c5d41096fe22832d25'), 'symfony/deprecation-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '5fa56b4074d1ae755beb55617ddafe6f5d78f665'), 'symfony/error-handler' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '59b190ce16ddf32771a22087b60f6dafd3407147'), 'symfony/event-dispatcher' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '1c93f7a1dff592c252574c79a8635a8a80856042'), 'symfony/event-dispatcher-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '0ba7d54483095a198fa51781bc608d17e84dffa2'), 'symfony/event-dispatcher-implementation' => array('provided' => array(0 => '2.0')), 'symfony/filesystem' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => 'fa8f8cab6b65e2d99a118e082935344c5ba8c60d'), 'symfony/finder' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '0b9231a5922fd7287ba5b411893c0ecd2733e5ba'), 'symfony/http-client-contracts' => array('pretty_version' => 'v2.3.1', 'version' => '2.3.1.0', 'aliases' => array(), 'reference' => '41db680a15018f9c1d4b23516059633ce280ca33'), 'symfony/http-foundation' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => 'a1f6218b29897ab52acba58cfa905b83625bef8d'), 'symfony/http-kernel' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '1feb619286d819180f7b8bc0dc44f516d9c62647'), 'symfony/polyfill-ctype' => array('pretty_version' => 'v1.22.0', 'version' => '1.22.0.0', 'aliases' => array(), 'reference' => 'c6c942b1ac76c82448322025e084cadc56048b4e'), 'symfony/polyfill-intl-grapheme' => array('pretty_version' => 'v1.22.0', 'version' => '1.22.0.0', 'aliases' => array(), 'reference' => '267a9adeb8ecb8071040a740930e077cdfb987af'), 'symfony/polyfill-intl-normalizer' => array('pretty_version' => 'v1.22.0', 'version' => '1.22.0.0', 'aliases' => array(), 'reference' => '6e971c891537eb617a00bb07a43d182a6915faba'), 'symfony/polyfill-mbstring' => array('pretty_version' => 'v1.22.0', 'version' => '1.22.0.0', 'aliases' => array(), 'reference' => 'f377a3dd1fde44d37b9831d68dc8dea3ffd28e13'), 'symfony/polyfill-php73' => array('pretty_version' => 'v1.22.0', 'version' => '1.22.0.0', 'aliases' => array(), 'reference' => 'a678b42e92f86eca04b7fa4c0f6f19d097fb69e2'), 'symfony/polyfill-php80' => array('pretty_version' => 'v1.22.0', 'version' => '1.22.0.0', 'aliases' => array(), 'reference' => 'dc3063ba22c2a1fd2f45ed856374d79114998f91'), 'symfony/service-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => 'd15da7ba4957ffb8f1747218be9e1a121fd298a1'), 'symfony/service-implementation' => array('provided' => array(0 => '1.0')), 'symfony/string' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '5bd67751d2e3f7d6f770c9154b8fbcb2aa05f7ed'), 'symfony/var-dumper' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '13e7e882eaa55863faa7c4ad7c60f12f1a8b5089'), 'symfony/var-exporter' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => 'fbc3507f23d263d75417e09a12d77c009f39676c'), 'symfony/yaml' => array('pretty_version' => 'v5.2.1', 'version' => '5.2.1.0', 'aliases' => array(), 'reference' => '290ea5e03b8cf9b42c783163123f54441fb06939'), 'symplify/astral' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => '53021926cf9777b19e9f8456d870372567edce61'), 'symplify/autowire-array-parameter' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => 'e26af7b15da65aa1b4121ffdf9594cf154be40ff'), 'symplify/composer-json-manipulator' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => '76cfcb03f89d086b783faab72775461fad108e99'), 'symplify/console-color-diff' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => '5fc5e5f51bf55e5c551c33df483f0ac8da8be14d'), 'symplify/console-package-builder' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => 'a00ff7cf292dc35fbb92d11b5feafedc0570b1d7'), 'symplify/easy-testing' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => '111ba416eeb03841de53a7efabc57091b5c6911b'), 'symplify/markdown-diff' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => '396fc73dbcc5e877b64573a50b7eeb75369bd8e6'), 'symplify/package-builder' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => '6967a8682007783c5f0f4febb263e194673c801b'), 'symplify/php-config-printer' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => 'a95737d2ca2216f777545c6706b282c6752c2693'), 'symplify/rule-doc-generator' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => '36ecc8ac559af47ee00efe5ed034f4e6d975b7ff'), 'symplify/set-config-resolver' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => 'fff4e2750e612ae4fdc268b0ecd0d82f3def25b6'), 'symplify/simple-php-doc-parser' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => '68fe5136079f689ccde5e9252ce20f0e0aeefe48'), 'symplify/skipper' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => '0920b245d0fc90cd7601291955d2200114836ba1'), 'symplify/smart-file-system' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => 'b13f436fc55d54ec76fd8b2a47bdf293faa7da9d'), 'symplify/symfony-php-config' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => '26117f72545e920e3b9c53644ef3f270de808ca7'), 'symplify/symplify-kernel' => array('pretty_version' => '9.0.40', 'version' => '9.0.40.0', 'aliases' => array(), 'reference' => '6a25becc72071a782028048b68160990dd439714'), 'webmozart/assert' => array('pretty_version' => '1.9.1', 'version' => '1.9.1.0', 'aliases' => array(), 'reference' => 'bafc69caeb4d49c39fd0779086c03a3738cbb389')));
    public static function getInstalledPackages()
    {
        return \array_keys(self::$installed['versions']);
    }
    public static function isInstalled($packageName)
    {
        return isset(self::$installed['versions'][$packageName]);
    }
    public static function satisfies(\RectorPrefix20210119\Composer\Semver\VersionParser $parser, $packageName, $constraint)
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
