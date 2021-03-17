<?php

namespace RectorPrefix20210317\Composer;

use RectorPrefix20210317\Composer\Autoload\ClassLoader;
use RectorPrefix20210317\Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => 'dev-main', 'version' => 'dev-main', 'aliases' => array(), 'reference' => '6ad6bdc2d7d41525df122c525d5c202e613f4e2f', 'name' => 'rector/rector'), 'versions' => array('composer/semver' => array('pretty_version' => '3.2.4', 'version' => '3.2.4.0', 'aliases' => array(), 'reference' => 'a02fdf930a3c1c3ed3a49b5f63859c0c20e10464'), 'composer/xdebug-handler' => array('pretty_version' => '1.4.5', 'version' => '1.4.5.0', 'aliases' => array(), 'reference' => 'f28d44c286812c714741478d968104c5e604a1d4'), 'danielstjules/stringy' => array('pretty_version' => '3.1.0', 'version' => '3.1.0.0', 'aliases' => array(), 'reference' => 'df24ab62d2d8213bbbe88cc36fc35a4503b4bd7e'), 'doctrine/annotations' => array('pretty_version' => '1.12.1', 'version' => '1.12.1.0', 'aliases' => array(), 'reference' => 'b17c5014ef81d212ac539f07a1001832df1b6d3b'), 'doctrine/inflector' => array('pretty_version' => '2.0.3', 'version' => '2.0.3.0', 'aliases' => array(), 'reference' => '9cf661f4eb38f7c881cac67c75ea9b00bf97b210'), 'doctrine/lexer' => array('pretty_version' => '1.2.1', 'version' => '1.2.1.0', 'aliases' => array(), 'reference' => 'e864bbf5904cb8f5bb334f99209b48018522f042'), 'jean85/pretty-package-versions' => array('pretty_version' => '2.0.3', 'version' => '2.0.3.0', 'aliases' => array(), 'reference' => 'b2c4ec2033a0196317a467cb197c7c843b794ddf'), 'nette/finder' => array('pretty_version' => 'v2.5.2', 'version' => '2.5.2.0', 'aliases' => array(), 'reference' => '4ad2c298eb8c687dd0e74ae84206a4186eeaed50'), 'nette/neon' => array('pretty_version' => 'v3.2.2', 'version' => '3.2.2.0', 'aliases' => array(), 'reference' => 'e4ca6f4669121ca6876b1d048c612480e39a28d5'), 'nette/robot-loader' => array('pretty_version' => 'v3.3.1', 'version' => '3.3.1.0', 'aliases' => array(), 'reference' => '15c1ecd0e6e69e8d908dfc4cca7b14f3b850a96b'), 'nette/utils' => array('pretty_version' => 'v3.2.2', 'version' => '3.2.2.0', 'aliases' => array(), 'reference' => '967cfc4f9a1acd5f1058d76715a424c53343c20c'), 'nikic/php-parser' => array('pretty_version' => 'v4.10.4', 'version' => '4.10.4.0', 'aliases' => array(), 'reference' => 'c6d052fc58cb876152f89f532b95a8d7907e7f0e'), 'phpstan/phpdoc-parser' => array('pretty_version' => '0.4.12', 'version' => '0.4.12.0', 'aliases' => array(), 'reference' => '2e17e4a90702d8b7ead58f4e08478a8e819ba6b8'), 'phpstan/phpstan' => array('pretty_version' => '0.12.81', 'version' => '0.12.81.0', 'aliases' => array(), 'reference' => '0dd5b0ebeff568f7000022ea5f04aa86ad3124b8'), 'phpstan/phpstan-phpunit' => array('pretty_version' => '0.12.18', 'version' => '0.12.18.0', 'aliases' => array(), 'reference' => 'ab44aec7cfb5cb267b8bc30a8caea86dd50d1f72'), 'psr/cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => 'd11b50ad223250cf17b86e38383413f5a6764bf8'), 'psr/cache-implementation' => array('provided' => array(0 => '1.0|2.0')), 'psr/container' => array('pretty_version' => '1.1.1', 'version' => '1.1.1.0', 'aliases' => array(), 'reference' => '8622567409010282b7aeebe4bb841fe98b58dcaf'), 'psr/container-implementation' => array('provided' => array(0 => '1.0')), 'psr/event-dispatcher' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0'), 'psr/event-dispatcher-implementation' => array('provided' => array(0 => '1.0')), 'psr/log' => array('pretty_version' => '1.1.3', 'version' => '1.1.3.0', 'aliases' => array(), 'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc'), 'psr/log-implementation' => array('provided' => array(0 => '1.0')), 'psr/simple-cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b'), 'psr/simple-cache-implementation' => array('provided' => array(0 => '1.0')), 'rector/rector' => array('pretty_version' => 'dev-main', 'version' => 'dev-main', 'aliases' => array(), 'reference' => '6ad6bdc2d7d41525df122c525d5c202e613f4e2f'), 'rector/rector-prefixed' => array('replaced' => array(0 => 'dev-main')), 'sebastian/diff' => array('pretty_version' => '4.0.4', 'version' => '4.0.4.0', 'aliases' => array(), 'reference' => '3461e3fccc7cfdfc2720be910d3bd73c69be590d'), 'symfony/cache' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => 'd15fb2576cdbe2c40d7c851e62f85b0faff3dd3d'), 'symfony/cache-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '8034ca0b61d4dd967f3698aaa1da2507b631d0cb'), 'symfony/cache-implementation' => array('provided' => array(0 => '1.0|2.0')), 'symfony/config' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '212d54675bf203ff8aef7d8cee8eecfb72f4a263'), 'symfony/console' => array('pretty_version' => 'v5.2.5', 'version' => '5.2.5.0', 'aliases' => array(), 'reference' => '938ebbadae1b0a9c9d1ec313f87f9708609f1b79'), 'symfony/dependency-injection' => array('pretty_version' => 'v5.2.5', 'version' => '5.2.5.0', 'aliases' => array(), 'reference' => 'be0c7926f5729b15e4e79fd2bf917cac584b1970'), 'symfony/deprecation-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '5fa56b4074d1ae755beb55617ddafe6f5d78f665'), 'symfony/error-handler' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => 'b547d3babcab5c31e01de59ee33e9d9c1421d7d0'), 'symfony/event-dispatcher' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => 'd08d6ec121a425897951900ab692b612a61d6240'), 'symfony/event-dispatcher-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '0ba7d54483095a198fa51781bc608d17e84dffa2'), 'symfony/event-dispatcher-implementation' => array('provided' => array(0 => '2.0')), 'symfony/filesystem' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '710d364200997a5afde34d9fe57bd52f3cc1e108'), 'symfony/finder' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '0d639a0943822626290d169965804f79400e6a04'), 'symfony/http-client-contracts' => array('pretty_version' => 'v2.3.1', 'version' => '2.3.1.0', 'aliases' => array(), 'reference' => '41db680a15018f9c1d4b23516059633ce280ca33'), 'symfony/http-foundation' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '54499baea7f7418bce7b5ec92770fd0799e8e9bf'), 'symfony/http-kernel' => array('pretty_version' => 'v5.2.5', 'version' => '5.2.5.0', 'aliases' => array(), 'reference' => 'b8c63ef63c2364e174c3b3e0ba0bf83455f97f73'), 'symfony/polyfill-ctype' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'c6c942b1ac76c82448322025e084cadc56048b4e'), 'symfony/polyfill-intl-grapheme' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => '5601e09b69f26c1828b13b6bb87cb07cddba3170'), 'symfony/polyfill-intl-normalizer' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => '43a0283138253ed1d48d352ab6d0bdb3f809f248'), 'symfony/polyfill-mbstring' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => '5232de97ee3b75b0360528dae24e73db49566ab1'), 'symfony/polyfill-php73' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'a678b42e92f86eca04b7fa4c0f6f19d097fb69e2'), 'symfony/polyfill-php80' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'dc3063ba22c2a1fd2f45ed856374d79114998f91'), 'symfony/polyfill-uuid' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => '9773608c15d3fe6ba2b6456a124777a7b8ffee2a'), 'symfony/process' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '313a38f09c77fbcdc1d223e57d368cea76a2fd2f'), 'symfony/service-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => 'd15da7ba4957ffb8f1747218be9e1a121fd298a1'), 'symfony/service-implementation' => array('provided' => array(0 => '1.0|2.0')), 'symfony/string' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '4e78d7d47061fa183639927ec40d607973699609'), 'symfony/uid' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '959f69a8c0d68a37311eeabd630a0ef0979bc1d0'), 'symfony/var-dumper' => array('pretty_version' => 'v5.2.5', 'version' => '5.2.5.0', 'aliases' => array(), 'reference' => '002ab5a36702adf0c9a11e6d8836623253e9045e'), 'symfony/var-exporter' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '5aed4875ab514c8cb9b6ff4772baa25fa4c10307'), 'symfony/yaml' => array('pretty_version' => 'v5.2.5', 'version' => '5.2.5.0', 'aliases' => array(), 'reference' => '298a08ddda623485208506fcee08817807a251dd'), 'symplify/astral' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => 'f8333cc8013c7886e415365c03470bfba23161c3'), 'symplify/autowire-array-parameter' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => 'b025de5230175f07ebd55d9f41488741e264ca19'), 'symplify/composer-json-manipulator' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => 'eb3b2adaeff937ee62263a454983963411b518ba'), 'symplify/console-color-diff' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => 'c7c084c77217cb14cad5fde90a85d4e215aa3ec7'), 'symplify/console-package-builder' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => '789d34d97e1aa1632c3ed569932b268434fb212c'), 'symplify/easy-testing' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => '7e17a387096185cb1b8cb5ce2d9bce9589329c2b'), 'symplify/markdown-diff' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => '6b082f50e6b7abae1713d067f7b80c5c1451df44'), 'symplify/package-builder' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => '0fe372aa5fbe08e339bb085d02b840583cd7b5b9'), 'symplify/php-config-printer' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => '35faa0f40ee8bb979268c5fbbf17d93ead9cf32c'), 'symplify/rule-doc-generator' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => 'c6b050a8411c12bba7774936de42ae68b3d2bd83'), 'symplify/set-config-resolver' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => '361771ac3b71a87d4a89fe4a9bc8f2353e6126a5'), 'symplify/simple-php-doc-parser' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => '69ae28060e87ec710cc581590e7882e349db6002'), 'symplify/skipper' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => '03edea77b06f81fa95a1bd97c427984e9b9f633b'), 'symplify/smart-file-system' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => 'd7a222bf576248700aa376fed6727ff665493c02'), 'symplify/symfony-php-config' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => 'cf76989df56b17d8a07affb16a41bd454a2ef105'), 'symplify/symplify-kernel' => array('pretty_version' => 'v9.2.11', 'version' => '9.2.11.0', 'aliases' => array(), 'reference' => 'b32de94fb1663c499cecbc3e2e6bca05c3927618'), 'webmozart/assert' => array('pretty_version' => '1.10.0', 'version' => '1.10.0.0', 'aliases' => array(), 'reference' => '6964c76c7804814a842473e0c8fd15bab0f18e25')));
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
    public static function satisfies(\RectorPrefix20210317\Composer\Semver\VersionParser $parser, $packageName, $constraint)
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
            self::$canGetVendors = \method_exists('RectorPrefix20210317\\Composer\\Autoload\\ClassLoader', 'getRegisteredLoaders');
        }
        $installed = array();
        if (self::$canGetVendors) {
            foreach (\RectorPrefix20210317\Composer\Autoload\ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
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
\class_alias('RectorPrefix20210317\\Composer\\InstalledVersions', 'Composer\\InstalledVersions', \false);
