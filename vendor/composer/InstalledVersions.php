<?php

namespace RectorPrefix20210428\Composer;

use RectorPrefix20210428\Composer\Autoload\ClassLoader;
use RectorPrefix20210428\Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => 'dev-main', 'version' => 'dev-main', 'aliases' => array(0 => '0.10.x-dev'), 'reference' => NULL, 'name' => 'rector/rector'), 'versions' => array('composer/semver' => array('pretty_version' => '3.2.4', 'version' => '3.2.4.0', 'aliases' => array(), 'reference' => 'a02fdf930a3c1c3ed3a49b5f63859c0c20e10464'), 'composer/xdebug-handler' => array('pretty_version' => '1.4.6', 'version' => '1.4.6.0', 'aliases' => array(), 'reference' => 'f27e06cd9675801df441b3656569b328e04aa37c'), 'danielstjules/stringy' => array('pretty_version' => '3.1.0', 'version' => '3.1.0.0', 'aliases' => array(), 'reference' => 'df24ab62d2d8213bbbe88cc36fc35a4503b4bd7e'), 'doctrine/inflector' => array('pretty_version' => '2.0.3', 'version' => '2.0.3.0', 'aliases' => array(), 'reference' => '9cf661f4eb38f7c881cac67c75ea9b00bf97b210'), 'jean85/pretty-package-versions' => array('pretty_version' => '2.0.3', 'version' => '2.0.3.0', 'aliases' => array(), 'reference' => 'b2c4ec2033a0196317a467cb197c7c843b794ddf'), 'nette/caching' => array('pretty_version' => 'v3.1.1', 'version' => '3.1.1.0', 'aliases' => array(), 'reference' => '3e771c589dee414724be473c24ad16dae50c1960'), 'nette/finder' => array('pretty_version' => 'v2.5.2', 'version' => '2.5.2.0', 'aliases' => array(), 'reference' => '4ad2c298eb8c687dd0e74ae84206a4186eeaed50'), 'nette/neon' => array('pretty_version' => 'v3.2.2', 'version' => '3.2.2.0', 'aliases' => array(), 'reference' => 'e4ca6f4669121ca6876b1d048c612480e39a28d5'), 'nette/robot-loader' => array('pretty_version' => 'v3.4.0', 'version' => '3.4.0.0', 'aliases' => array(), 'reference' => '3973cf3970d1de7b30888fd10b92dac9e0c2fd82'), 'nette/utils' => array('pretty_version' => 'v3.2.2', 'version' => '3.2.2.0', 'aliases' => array(), 'reference' => '967cfc4f9a1acd5f1058d76715a424c53343c20c'), 'nikic/php-parser' => array('pretty_version' => 'v4.10.4', 'version' => '4.10.4.0', 'aliases' => array(), 'reference' => 'c6d052fc58cb876152f89f532b95a8d7907e7f0e'), 'phpstan/phpdoc-parser' => array('pretty_version' => '0.5.4', 'version' => '0.5.4.0', 'aliases' => array(), 'reference' => 'e352d065af1ae9b41c12d1dfd309e90f7b1f55c9'), 'phpstan/phpstan' => array('pretty_version' => '0.12.85', 'version' => '0.12.85.0', 'aliases' => array(), 'reference' => '20e6333c0067875ad7697cd8acdf245c6ef69d03'), 'phpstan/phpstan-phpunit' => array('pretty_version' => '0.12.18', 'version' => '0.12.18.0', 'aliases' => array(), 'reference' => 'ab44aec7cfb5cb267b8bc30a8caea86dd50d1f72'), 'psr/container' => array('pretty_version' => '1.1.1', 'version' => '1.1.1.0', 'aliases' => array(), 'reference' => '8622567409010282b7aeebe4bb841fe98b58dcaf'), 'psr/container-implementation' => array('provided' => array(0 => '1.0')), 'psr/event-dispatcher' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0'), 'psr/event-dispatcher-implementation' => array('provided' => array(0 => '1.0')), 'psr/log' => array('pretty_version' => '1.1.3', 'version' => '1.1.3.0', 'aliases' => array(), 'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc'), 'psr/log-implementation' => array('provided' => array(0 => '1.0')), 'rector/rector' => array('pretty_version' => 'dev-main', 'version' => 'dev-main', 'aliases' => array(0 => '0.10.x-dev'), 'reference' => NULL), 'rector/rector-cakephp' => array('pretty_version' => '0.10.4', 'version' => '0.10.4.0', 'aliases' => array(), 'reference' => '5155ac30d2cd04144690c118a030af0a4a1e68f4'), 'rector/rector-doctrine' => array('pretty_version' => '0.10.6', 'version' => '0.10.6.0', 'aliases' => array(), 'reference' => '52dbdf1d60c522c1c40142a194960610db451f91'), 'rector/rector-installer' => array('pretty_version' => '0.10.1', 'version' => '0.10.1.0', 'aliases' => array(), 'reference' => '2e8df01aac6a3dedd113ba57ea6f129b6a9872c9'), 'rector/rector-laravel' => array('pretty_version' => '0.10.2', 'version' => '0.10.2.0', 'aliases' => array(), 'reference' => 'd4ccd50d7975bea9a0ce961bbaded385b5ede739'), 'rector/rector-nette' => array('pretty_version' => '0.10.9', 'version' => '0.10.9.0', 'aliases' => array(), 'reference' => '19c85c870f9a7a90d1f2e9be9b3e048b4db69697'), 'rector/rector-phpunit' => array('pretty_version' => '0.10.8', 'version' => '0.10.8.0', 'aliases' => array(), 'reference' => '2b272b61cacf29bf0e448719165c8376cd41872e'), 'rector/rector-prefixed' => array('replaced' => array(0 => '0.10.x-dev', 1 => 'dev-main')), 'rector/rector-symfony' => array('pretty_version' => '0.10.6', 'version' => '0.10.6.0', 'aliases' => array(), 'reference' => '583e77ad2fc8c7740418d55884beb3d18822e115'), 'sebastian/diff' => array('pretty_version' => '4.0.4', 'version' => '4.0.4.0', 'aliases' => array(), 'reference' => '3461e3fccc7cfdfc2720be910d3bd73c69be590d'), 'symfony/config' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '212d54675bf203ff8aef7d8cee8eecfb72f4a263'), 'symfony/console' => array('pretty_version' => 'v5.2.6', 'version' => '5.2.6.0', 'aliases' => array(), 'reference' => '35f039df40a3b335ebf310f244cb242b3a83ac8d'), 'symfony/dependency-injection' => array('pretty_version' => 'v5.2.6', 'version' => '5.2.6.0', 'aliases' => array(), 'reference' => '1e66194bed2a69fa395d26bf1067e5e34483afac'), 'symfony/deprecation-contracts' => array('pretty_version' => 'v2.4.0', 'version' => '2.4.0.0', 'aliases' => array(), 'reference' => '5f38c8804a9e97d23e0c8d63341088cd8a22d627'), 'symfony/error-handler' => array('pretty_version' => 'v5.2.6', 'version' => '5.2.6.0', 'aliases' => array(), 'reference' => 'bdb7fb4188da7f4211e4b88350ba0dfdad002b03'), 'symfony/event-dispatcher' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => 'd08d6ec121a425897951900ab692b612a61d6240'), 'symfony/event-dispatcher-contracts' => array('pretty_version' => 'v2.4.0', 'version' => '2.4.0.0', 'aliases' => array(), 'reference' => '69fee1ad2332a7cbab3aca13591953da9cdb7a11'), 'symfony/event-dispatcher-implementation' => array('provided' => array(0 => '2.0')), 'symfony/filesystem' => array('pretty_version' => 'v5.2.6', 'version' => '5.2.6.0', 'aliases' => array(), 'reference' => '8c86a82f51658188119e62cff0a050a12d09836f'), 'symfony/finder' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '0d639a0943822626290d169965804f79400e6a04'), 'symfony/http-client-contracts' => array('pretty_version' => 'v2.4.0', 'version' => '2.4.0.0', 'aliases' => array(), 'reference' => '7e82f6084d7cae521a75ef2cb5c9457bbda785f4'), 'symfony/http-foundation' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '54499baea7f7418bce7b5ec92770fd0799e8e9bf'), 'symfony/http-kernel' => array('pretty_version' => 'v5.2.6', 'version' => '5.2.6.0', 'aliases' => array(), 'reference' => 'f34de4c61ca46df73857f7f36b9a3805bdd7e3b2'), 'symfony/polyfill-ctype' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'c6c942b1ac76c82448322025e084cadc56048b4e'), 'symfony/polyfill-intl-grapheme' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => '5601e09b69f26c1828b13b6bb87cb07cddba3170'), 'symfony/polyfill-intl-normalizer' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => '43a0283138253ed1d48d352ab6d0bdb3f809f248'), 'symfony/polyfill-mbstring' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => '5232de97ee3b75b0360528dae24e73db49566ab1'), 'symfony/polyfill-php73' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'a678b42e92f86eca04b7fa4c0f6f19d097fb69e2'), 'symfony/polyfill-php80' => array('pretty_version' => 'v1.22.1', 'version' => '1.22.1.0', 'aliases' => array(), 'reference' => 'dc3063ba22c2a1fd2f45ed856374d79114998f91'), 'symfony/process' => array('pretty_version' => 'v5.2.4', 'version' => '5.2.4.0', 'aliases' => array(), 'reference' => '313a38f09c77fbcdc1d223e57d368cea76a2fd2f'), 'symfony/service-contracts' => array('pretty_version' => 'v2.4.0', 'version' => '2.4.0.0', 'aliases' => array(), 'reference' => 'f040a30e04b57fbcc9c6cbcf4dbaa96bd318b9bb'), 'symfony/service-implementation' => array('provided' => array(0 => '1.0|2.0')), 'symfony/string' => array('pretty_version' => 'v5.2.6', 'version' => '5.2.6.0', 'aliases' => array(), 'reference' => 'ad0bd91bce2054103f5eaa18ebeba8d3bc2a0572'), 'symfony/var-dumper' => array('pretty_version' => 'v5.2.6', 'version' => '5.2.6.0', 'aliases' => array(), 'reference' => '89412a68ea2e675b4e44f260a5666729f77f668e'), 'symplify/astral' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => '9707ba1a438bb0e22dca731ac16a47cb9944d1df'), 'symplify/autowire-array-parameter' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => 'ad7db59a20df653b563a7b2e6875d530db359e16'), 'symplify/composer-json-manipulator' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => 'd988a434f08055aed92ff7ba284b274c7fa4d050'), 'symplify/console-color-diff' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => '85dddabe5ed45a47bb325038f6c14b37014d96c1'), 'symplify/console-package-builder' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => 'b59e4b46ba143e0b9f0589f842d840aab8bffacf'), 'symplify/easy-testing' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => 'd8bc9e2388ede8d3685f06ed9bc23285df97a550'), 'symplify/package-builder' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => '003f5cd77f48cb729f03999d0b5afc5e6cfbc90a'), 'symplify/rule-doc-generator-contracts' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => 'b02f4b86397534e1afcf5d6466b15fb54b89f11c'), 'symplify/set-config-resolver' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => 'fd8f515d293aaec34e1c631226641ac3e82f012d'), 'symplify/simple-php-doc-parser' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => 'b66e8ee42c45650a01a68ba88dfcc9d4442346fb'), 'symplify/skipper' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => '9cd7ec1b15f55d474a006690db34eef648c01c00'), 'symplify/smart-file-system' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => 'd7a222bf576248700aa376fed6727ff665493c02'), 'symplify/symfony-php-config' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => '0a5bf9f1d7d970f2df2b4e4225c297bd774c23c8'), 'symplify/symplify-kernel' => array('pretty_version' => 'v9.3.0', 'version' => '9.3.0.0', 'aliases' => array(), 'reference' => '0c9b154f26f06007a1c0df32a608c24efb1cb605'), 'tracy/tracy' => array('pretty_version' => 'v2.8.4', 'version' => '2.8.4.0', 'aliases' => array(), 'reference' => 'cb7d3dcd9469aa2aa6722edf6bee2d5d75188079'), 'webmozart/assert' => array('pretty_version' => '1.10.0', 'version' => '1.10.0.0', 'aliases' => array(), 'reference' => '6964c76c7804814a842473e0c8fd15bab0f18e25')));
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
    public static function satisfies(\RectorPrefix20210428\Composer\Semver\VersionParser $parser, $packageName, $constraint)
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
            self::$canGetVendors = \method_exists('RectorPrefix20210428\\Composer\\Autoload\\ClassLoader', 'getRegisteredLoaders');
        }
        $installed = array();
        if (self::$canGetVendors) {
            foreach (\RectorPrefix20210428\Composer\Autoload\ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
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
\class_alias('RectorPrefix20210428\\Composer\\InstalledVersions', 'Composer\\InstalledVersions', \false);
