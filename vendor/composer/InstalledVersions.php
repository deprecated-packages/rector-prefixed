<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'dev-main',
    'version' => 'dev-main',
    'aliases' => 
    array (
      0 => '0.10.x-dev',
    ),
    'reference' => NULL,
    'name' => 'rector/rector',
  ),
  'versions' => 
  array (
    'composer/semver' => 
    array (
      'pretty_version' => '3.2.4',
      'version' => '3.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a02fdf930a3c1c3ed3a49b5f63859c0c20e10464',
    ),
    'composer/xdebug-handler' => 
    array (
      'pretty_version' => '1.4.6',
      'version' => '1.4.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f27e06cd9675801df441b3656569b328e04aa37c',
    ),
    'danielstjules/stringy' => 
    array (
      'pretty_version' => '3.1.0',
      'version' => '3.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'df24ab62d2d8213bbbe88cc36fc35a4503b4bd7e',
    ),
    'doctrine/inflector' => 
    array (
      'pretty_version' => '2.0.3',
      'version' => '2.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '9cf661f4eb38f7c881cac67c75ea9b00bf97b210',
    ),
    'jean85/pretty-package-versions' => 
    array (
      'pretty_version' => '2.0.3',
      'version' => '2.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b2c4ec2033a0196317a467cb197c7c843b794ddf',
    ),
    'nette/caching' => 
    array (
      'pretty_version' => 'v3.1.1',
      'version' => '3.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '3e771c589dee414724be473c24ad16dae50c1960',
    ),
    'nette/finder' => 
    array (
      'pretty_version' => 'v2.5.2',
      'version' => '2.5.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '4ad2c298eb8c687dd0e74ae84206a4186eeaed50',
    ),
    'nette/neon' => 
    array (
      'pretty_version' => 'v3.2.2',
      'version' => '3.2.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e4ca6f4669121ca6876b1d048c612480e39a28d5',
    ),
    'nette/robot-loader' => 
    array (
      'pretty_version' => 'v3.4.0',
      'version' => '3.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '3973cf3970d1de7b30888fd10b92dac9e0c2fd82',
    ),
    'nette/utils' => 
    array (
      'pretty_version' => 'v3.2.2',
      'version' => '3.2.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '967cfc4f9a1acd5f1058d76715a424c53343c20c',
    ),
    'nikic/php-parser' => 
    array (
      'pretty_version' => 'v4.10.4',
      'version' => '4.10.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c6d052fc58cb876152f89f532b95a8d7907e7f0e',
    ),
    'phpstan/phpdoc-parser' => 
    array (
      'pretty_version' => '0.5.4',
      'version' => '0.5.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e352d065af1ae9b41c12d1dfd309e90f7b1f55c9',
    ),
    'phpstan/phpstan' => 
    array (
      'pretty_version' => '0.12.83',
      'version' => '0.12.83.0',
      'aliases' => 
      array (
      ),
      'reference' => '4a967cec6efb46b500dd6d768657336a3ffe699f',
    ),
    'phpstan/phpstan-phpunit' => 
    array (
      'pretty_version' => '0.12.18',
      'version' => '0.12.18.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ab44aec7cfb5cb267b8bc30a8caea86dd50d1f72',
    ),
    'psr/container' => 
    array (
      'pretty_version' => '1.1.1',
      'version' => '1.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '8622567409010282b7aeebe4bb841fe98b58dcaf',
    ),
    'psr/container-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/event-dispatcher' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0',
    ),
    'psr/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/log' => 
    array (
      'pretty_version' => '1.1.3',
      'version' => '1.1.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc',
    ),
    'psr/log-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'rector/rector' => 
    array (
      'pretty_version' => 'dev-main',
      'version' => 'dev-main',
      'aliases' => 
      array (
        0 => '0.10.x-dev',
      ),
      'reference' => NULL,
    ),
    'rector/rector-cakephp' => 
    array (
      'pretty_version' => '0.10.3',
      'version' => '0.10.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '25cfd2b68c2c995e79d61a241d74d5adebe57538',
    ),
    'rector/rector-doctrine' => 
    array (
      'pretty_version' => '0.10.2',
      'version' => '0.10.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '3d22958431fdeca89388667a9caec52bb0eb9832',
    ),
    'rector/rector-laravel' => 
    array (
      'pretty_version' => '0.10.1',
      'version' => '0.10.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd821ae834d7311c92fde91b12d6293c3590c9c5a',
    ),
    'rector/rector-nette' => 
    array (
      'pretty_version' => '0.10.5',
      'version' => '0.10.5.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ada32a577959df278cddce1da7251bf565028853',
    ),
    'rector/rector-phpunit' => 
    array (
      'pretty_version' => '0.10.6',
      'version' => '0.10.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bafe2fa86b30739a0defb87041145b9f5f0a7db1',
    ),
    'rector/rector-prefixed' => 
    array (
      'replaced' => 
      array (
        0 => '0.10.x-dev',
        1 => 'dev-main',
      ),
    ),
    'rector/rector-symfony' => 
    array (
      'pretty_version' => '0.10.3',
      'version' => '0.10.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '32cdf3f3e78a0afaecaf8c3c89fd0b7b78072aab',
    ),
    'sebastian/diff' => 
    array (
      'pretty_version' => '4.0.4',
      'version' => '4.0.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '3461e3fccc7cfdfc2720be910d3bd73c69be590d',
    ),
    'symfony/config' => 
    array (
      'pretty_version' => 'v5.2.4',
      'version' => '5.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '212d54675bf203ff8aef7d8cee8eecfb72f4a263',
    ),
    'symfony/console' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '35f039df40a3b335ebf310f244cb242b3a83ac8d',
    ),
    'symfony/dependency-injection' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '1e66194bed2a69fa395d26bf1067e5e34483afac',
    ),
    'symfony/deprecation-contracts' => 
    array (
      'pretty_version' => 'v2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '5fa56b4074d1ae755beb55617ddafe6f5d78f665',
    ),
    'symfony/error-handler' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bdb7fb4188da7f4211e4b88350ba0dfdad002b03',
    ),
    'symfony/event-dispatcher' => 
    array (
      'pretty_version' => 'v5.2.4',
      'version' => '5.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd08d6ec121a425897951900ab692b612a61d6240',
    ),
    'symfony/event-dispatcher-contracts' => 
    array (
      'pretty_version' => 'v2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0ba7d54483095a198fa51781bc608d17e84dffa2',
    ),
    'symfony/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '2.0',
      ),
    ),
    'symfony/filesystem' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '8c86a82f51658188119e62cff0a050a12d09836f',
    ),
    'symfony/finder' => 
    array (
      'pretty_version' => 'v5.2.4',
      'version' => '5.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '0d639a0943822626290d169965804f79400e6a04',
    ),
    'symfony/http-client-contracts' => 
    array (
      'pretty_version' => 'v2.3.1',
      'version' => '2.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '41db680a15018f9c1d4b23516059633ce280ca33',
    ),
    'symfony/http-foundation' => 
    array (
      'pretty_version' => 'v5.2.4',
      'version' => '5.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '54499baea7f7418bce7b5ec92770fd0799e8e9bf',
    ),
    'symfony/http-kernel' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f34de4c61ca46df73857f7f36b9a3805bdd7e3b2',
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c6c942b1ac76c82448322025e084cadc56048b4e',
    ),
    'symfony/polyfill-intl-grapheme' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '5601e09b69f26c1828b13b6bb87cb07cddba3170',
    ),
    'symfony/polyfill-intl-normalizer' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '43a0283138253ed1d48d352ab6d0bdb3f809f248',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '5232de97ee3b75b0360528dae24e73db49566ab1',
    ),
    'symfony/polyfill-php72' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cc6e6f9b39fe8075b3dabfbaf5b5f645ae1340c9',
    ),
    'symfony/polyfill-php73' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a678b42e92f86eca04b7fa4c0f6f19d097fb69e2',
    ),
    'symfony/polyfill-php74' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '577e147350331efeb816897e004d85e6e765daaf',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'dc3063ba22c2a1fd2f45ed856374d79114998f91',
    ),
    'symfony/polyfill-uuid' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '9773608c15d3fe6ba2b6456a124777a7b8ffee2a',
    ),
    'symfony/process' => 
    array (
      'pretty_version' => 'v5.2.4',
      'version' => '5.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '313a38f09c77fbcdc1d223e57d368cea76a2fd2f',
    ),
    'symfony/service-contracts' => 
    array (
      'pretty_version' => 'v2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd15da7ba4957ffb8f1747218be9e1a121fd298a1',
    ),
    'symfony/service-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0|2.0',
      ),
    ),
    'symfony/string' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ad0bd91bce2054103f5eaa18ebeba8d3bc2a0572',
    ),
    'symfony/uid' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '47d4347b762f0bab9b4ec02112ddfaaa6d79481b',
    ),
    'symfony/var-dumper' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '89412a68ea2e675b4e44f260a5666729f77f668e',
    ),
    'symplify/astral' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '4f089c71676f20df0ed7fc211e0d71bd0b8b7eb2',
    ),
    'symplify/autowire-array-parameter' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e6035c7e4dd1edc98f5d36cac8d7ae46a4a2b8f5',
    ),
    'symplify/composer-json-manipulator' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '6fcd10db4a487a09dc168b9d0b51e8848dfb0a8a',
    ),
    'symplify/console-color-diff' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '70c480c08be45e8662f67949777095f94fbcdd6a',
    ),
    'symplify/console-package-builder' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '74cc5a1028823ec1a1801f9d9287b9ab5d472874',
    ),
    'symplify/easy-testing' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bc885aa017cb0c5651d4bd3dbb88a81a789b5cd3',
    ),
    'symplify/package-builder' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '11fb59bb2d6e326929e397064efe185b31359a65',
    ),
    'symplify/rule-doc-generator-contracts' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b02f4b86397534e1afcf5d6466b15fb54b89f11c',
    ),
    'symplify/set-config-resolver' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '66dbcd46858af4cc6359c9d2a2ff4666fe42a227',
    ),
    'symplify/simple-php-doc-parser' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '499e58689e9c65d1690b50b34186ff74b1f93def',
    ),
    'symplify/skipper' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bcfde041ec189fa8c187decc2a9b91199975de67',
    ),
    'symplify/smart-file-system' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd7a222bf576248700aa376fed6727ff665493c02',
    ),
    'symplify/symfony-php-config' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ec1732f9e2a063e38bc7451dd349ce307b68f44f',
    ),
    'symplify/symplify-kernel' => 
    array (
      'pretty_version' => 'v9.2.16',
      'version' => '9.2.16.0',
      'aliases' => 
      array (
      ),
      'reference' => '864cb4089ae36b648428092088a31d1f70287446',
    ),
    'webmozart/assert' => 
    array (
      'pretty_version' => '1.10.0',
      'version' => '1.10.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '6964c76c7804814a842473e0c8fd15bab0f18e25',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}


if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
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
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
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
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {
foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
