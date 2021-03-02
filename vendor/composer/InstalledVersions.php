<?php

namespace RectorPrefix20210302\Composer;

use RectorPrefix20210302\Composer\Autoload\ClassLoader;
use RectorPrefix20210302\Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => '0ffabe49ad0aa1bfb8b925c1e6f0873782f3bf0d', 'name' => 'rector/rector'), 'versions' => array('composer/package-versions-deprecated' => array('pretty_version' => '1.11.99.1', 'version' => '1.11.99.1', 'aliases' => array(), 'reference' => '7413f0b55a051e89485c5cb9f765fe24bb02a7b6'), 'composer/semver' => array('pretty_version' => '3.2.4', 'version' => '3.2.4.0', 'aliases' => array(), 'reference' => 'a02fdf930a3c1c3ed3a49b5f63859c0c20e10464'), 'composer/xdebug-handler' => array('pretty_version' => '1.4.5', 'version' => '1.4.5.0', 'aliases' => array(), 'reference' => 'f28d44c286812c714741478d968104c5e604a1d4'), 'doctrine/annotations' => array('pretty_version' => '1.12.1', 'version' => '1.12.1.0', 'aliases' => array(), 'reference' => 'b17c5014ef81d212ac539f07a1001832df1b6d3b'), 'doctrine/inflector' => array('pretty_version' => '2.0.3', 'version' => '2.0.3.0', 'aliases' => array(), 'reference' => '9cf661f4eb38f7c881cac67c75ea9b00bf97b210'), 'doctrine/lexer' => array('pretty_version' => '1.2.1', 'version' => '1.2.1.0', 'aliases' => array(), 'reference' => 'e864bbf5904cb8f5bb334f99209b48018522f042'), 'jean85/pretty-package-versions' => array('pretty_version' => '1.6.0', 'version' => '1.6.0.0', 'aliases' => array(), 'reference' => '1e0104b46f045868f11942aea058cd7186d6c303'), 'nette/finder' => array('pretty_version' => 'v2.5.2', 'version' => '2.5.2.0', 'aliases' => array(), 'reference' => '4ad2c298eb8c687dd0e74ae84206a4186eeaed50'), 'nette/neon' => array('pretty_version' => 'v3.2.2', 'version' => '3.2.2.0', 'aliases' => array(), 'reference' => 'e4ca6f4669121ca6876b1d048c612480e39a28d5'), 'nette/robot-loader' => array('pretty_version' => 'v3.3.1', 'version' => '3.3.1.0', 'aliases' => array(), 'reference' => '15c1ecd0e6e69e8d908dfc4cca7b14f3b850a96b'), 'nette/utils' => array('pretty_version' => 'v3.2.1', 'version' => '3.2.1.0', 'aliases' => array(), 'reference' => '2bc2f58079c920c2ecbb6935645abf6f2f5f94ba'), 'nikic/php-parser' => array('pretty_version' => 'v4.10.4', 'version' => '4.10.4.0', 'aliases' => array(), 'reference' => 'c6d052fc58cb876152f89f532b95a8d7907e7f0e'), 'ocramius/package-versions' => array('replaced' => array(0 => '1.11.99')), 'phpstan/phpdoc-parser' => array('pretty_version' => '0.4.12', 'version' => '0.4.12.0', 'aliases' => array(), 'reference' => '2e17e4a90702d8b7ead58f4e08478a8e819ba6b8'), 'phpstan/phpstan' => array('pretty_version' => '0.12.80', 'version' => '0.12.80.0', 'aliases' => array(), 'reference' => 'c6a1b17f22ecf708d434d6bee05092647ec7e686'), 'phpstan/phpstan-phpunit' => array('pretty_version' => '0.12.17', 'version' => '0.12.17.0', 'aliases' => array(), 'reference' => '432575b41cf2d4f44e460234acaf56119ed97d36'), 'psr/cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => 'd11b50ad223250cf17b86e38383413f5a6764bf8'), 'psr/cache-implementation' => array('provided' => array(0 => '1.0')), 'psr/container' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'b7ce3b176482dbbc1245ebf52b181af44c2cf55f'), 'psr/container-implementation' => array('provided' => array(0 => '1.0')), 'psr/event-dispatcher' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0'), 'psr/event-dispatcher-implementation' => array('provided' => array(0 => '1.0')), 'psr/log' => array('pretty_version' => '1.1.3', 'version' => '1.1.3.0', 'aliases' => array(), 'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc'), 'psr/log-implementation' => array('provided' => array(0 => '1.0')), 'psr/simple-cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b'), 'psr/simple-cache-implementation' => array('provided' => array(0 => '1.0')), 'rector/rector' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => '0ffabe49ad0aa1bfb8b925c1e6f0873782f3bf0d'), 'rector/rector-prefixed' => array('replaced' => array(0 => 'dev-master')), 'sebastian/diff' => array('pretty_version' => '4.0.4', 'version' => '4.0.4.0', 'aliases' => array(), 'reference' => '3461e3fccc7cfdfc2720be910d3bd73c69be590d'), 'symfony/cache' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => 'd6aed6c1bbf6f59e521f46437475a0ff4878d388'), 'symfony/cache-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '8034ca0b61d4dd967f3698aaa1da2507b631d0cb'), 'symfony/cache-implementation' => array('provided' => array(0 => '1.0')), 'symfony/config' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '50e0e1314a3b2609d32b6a5a0d0fb5342494c4ab'), 'symfony/console' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '89d4b176d12a2946a1ae4e34906a025b7b6b135a'), 'symfony/dependency-injection' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '62f72187be689540385dce6c68a5d4c16f034139'), 'symfony/deprecation-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '5fa56b4074d1ae755beb55617ddafe6f5d78f665'), 'symfony/error-handler' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '48f18b3609e120ea66d59142c23dc53e9562c26d'), 'symfony/event-dispatcher' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '4f9760f8074978ad82e2ce854dff79a71fe45367'), 'symfony/event-dispatcher-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '0ba7d54483095a198fa51781bc608d17e84dffa2'), 'symfony/event-dispatcher-implementation' => array('provided' => array(0 => '2.0')), 'symfony/expression-language' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '7bf30a4e29887110f8bd1882ccc82ee63c8a5133'), 'symfony/filesystem' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '262d033b57c73e8b59cd6e68a45c528318b15038'), 'symfony/finder' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '4adc8d172d602008c204c2e16956f99257248e03'), 'symfony/http-client-contracts' => array('pretty_version' => 'v2.3.1', 'version' => '2.3.1.0', 'aliases' => array(), 'reference' => '41db680a15018f9c1d4b23516059633ce280ca33'), 'symfony/http-foundation' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '20c554c0f03f7cde5ce230ed248470cccbc34c36'), 'symfony/http-kernel' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '89bac04f29e7b0b52f9fa6a4288ca7a8f90a1a05'), 'symfony/polyfill-ctype' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'c6c942b1ac76c82448322025e084cadc56048b4e'), 'symfony/polyfill-intl-grapheme' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => '5601e09b69f26c1828b13b6bb87cb07cddba3170'), 'symfony/polyfill-intl-normalizer' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => '43a0283138253ed1d48d352ab6d0bdb3f809f248'), 'symfony/polyfill-mbstring' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => '5232de97ee3b75b0360528dae24e73db49566ab1'), 'symfony/polyfill-php73' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'a678b42e92f86eca04b7fa4c0f6f19d097fb69e2'), 'symfony/polyfill-php80' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'dc3063ba22c2a1fd2f45ed856374d79114998f91'), 'symfony/process' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '313a38f09c77fbcdc1d223e57d368cea76a2fd2f'), 'symfony/service-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => 'd15da7ba4957ffb8f1747218be9e1a121fd298a1'), 'symfony/service-implementation' => array('provided' => array(0 => '1.0')), 'symfony/string' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => 'c95468897f408dd0aca2ff582074423dd0455122'), 'symfony/var-dumper' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '72ca213014a92223a5d18651ce79ef441c12b694'), 'symfony/var-exporter' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '5aed4875ab514c8cb9b6ff4772baa25fa4c10307'), 'symfony/yaml' => array('pretty_version' => 'v5.2.3', 'version' => '5.2.3.0', 'aliases' => array(), 'reference' => '338cddc6d74929f6adf19ca5682ac4b8e109cdb0'), 'symplify/astral' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => '2fec3a847feb4c90e2eac70436b124c6f6ec4d8b'), 'symplify/autowire-array-parameter' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => '8daf626dc55284d36d69f6fce270930b2a7be462'), 'symplify/composer-json-manipulator' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => '239e9efc3d41cf60df7512c9449203418c590707'), 'symplify/console-color-diff' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => '8f4cd2e40c1e9685c34a72adc8273e60e8dc14b2'), 'symplify/console-package-builder' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => 'cf782495206ac8fca7d308f46c7ad6ac5bd79a92'), 'symplify/easy-testing' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => '5e8c10a525563e9d34cd404dd8c289c720b614c5'), 'symplify/markdown-diff' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => '7050b2ed0b0f33a722a46427cdf99a83fc3222fb'), 'symplify/package-builder' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => 'd43f747ae3095f2fd7a124f591c86f3930730b11'), 'symplify/php-config-printer' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => '1b007a8c46983daaeb9faa0692e02c84509b8ea7'), 'symplify/rule-doc-generator' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => '56f01cfdbb397acf13459e02b73fcb6cbbfdf673'), 'symplify/set-config-resolver' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => 'c2b1efccc41f496e82d9af497bc59cfe2d2212e9'), 'symplify/simple-php-doc-parser' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => 'b59683706f3b2b73e3fe203f04f58e5838a24580'), 'symplify/skipper' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => 'b77767be18e90ba1375fd06e80aa23d70d87ee3d'), 'symplify/smart-file-system' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => 'ef20e90676db3af6397de2b0dd86fb902cf872da'), 'symplify/symfony-php-config' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => 'a7a006d9674a61dcb430697d3bc9a2297c87d188'), 'symplify/symplify-kernel' => array('pretty_version' => 'v9.2.4', 'version' => '9.2.4.0', 'aliases' => array(), 'reference' => '319c0afde5e48aec50d091076d005ff0ebcc4aa3'), 'webmozart/assert' => array('pretty_version' => '1.9.1', 'version' => '1.9.1.0', 'aliases' => array(), 'reference' => 'bafc69caeb4d49c39fd0779086c03a3738cbb389')));
    private static $canGetVendors;
    private static $installedByVendor = array();
    public static function getInstalledPackages()
    {
        $packages = array();
        foreach (self::getInstalled() as $installed) {
            $packages[] = \array_keys($installed['versions']);
        }
        if (1 === \count($packages)) {
            return $packages[0];
        }
        return \array_keys(\array_flip(\call_user_func_array('array_merge', $packages)));
    }
    public static function isInstalled($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (isset($installed['versions'][$packageName])) {
                return \true;
            }
        }
        return \false;
    }
    public static function satisfies(\RectorPrefix20210302\Composer\Semver\VersionParser $parser, $packageName, $constraint)
    {
        $constraint = $parser->parseConstraints($constraint);
        $provided = $parser->parseConstraints(self::getVersionRanges($packageName));
        return $provided->matches($constraint);
    }
    public static function getVersionRanges($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            $ranges = array();
            if (isset($installed['versions'][$packageName]['pretty_version'])) {
                $ranges[] = $installed['versions'][$packageName]['pretty_version'];
            }
            if (\array_key_exists('aliases', $installed['versions'][$packageName])) {
                $ranges = \array_merge($ranges, $installed['versions'][$packageName]['aliases']);
            }
            if (\array_key_exists('replaced', $installed['versions'][$packageName])) {
                $ranges = \array_merge($ranges, $installed['versions'][$packageName]['replaced']);
            }
            if (\array_key_exists('provided', $installed['versions'][$packageName])) {
                $ranges = \array_merge($ranges, $installed['versions'][$packageName]['provided']);
            }
            return \implode(' || ', $ranges);
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getVersion($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['version'])) {
                return null;
            }
            return $installed['versions'][$packageName]['version'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getPrettyVersion($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['pretty_version'])) {
                return null;
            }
            return $installed['versions'][$packageName]['pretty_version'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getReference($packageName)
    {
        foreach (self::getInstalled() as $installed) {
            if (!isset($installed['versions'][$packageName])) {
                continue;
            }
            if (!isset($installed['versions'][$packageName]['reference'])) {
                return null;
            }
            return $installed['versions'][$packageName]['reference'];
        }
        throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
    }
    public static function getRootPackage()
    {
        $installed = self::getInstalled();
        return $installed[0]['root'];
    }
    public static function getRawData()
    {
        return self::$installed;
    }
    public static function reload($data)
    {
        self::$installed = $data;
        self::$installedByVendor = array();
    }
    private static function getInstalled()
    {
        if (null === self::$canGetVendors) {
            self::$canGetVendors = \method_exists('RectorPrefix20210302\\Composer\\Autoload\\ClassLoader', 'getRegisteredLoaders');
        }
        $installed = array();
        if (self::$canGetVendors) {
            foreach (\RectorPrefix20210302\Composer\Autoload\ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
                if (isset(self::$installedByVendor[$vendorDir])) {
                    $installed[] = self::$installedByVendor[$vendorDir];
                } elseif (\is_file($vendorDir . '/composer/installed.php')) {
                    $installed[] = self::$installedByVendor[$vendorDir] = (require $vendorDir . '/composer/installed.php');
                }
            }
        }
        $installed[] = self::$installed;
        return $installed;
    }
}
