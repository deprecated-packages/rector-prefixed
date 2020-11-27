<?php

namespace _PhpScoper88fe6e0ad041\Composer;

use _PhpScoper88fe6e0ad041\Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => 'c6f6b79749f54c3f3a556130dd3e33beda787805', 'name' => 'rector/rector'), 'versions' => array('clue/block-react' => array('pretty_version' => 'v1.4.0', 'version' => '1.4.0.0', 'aliases' => array(), 'reference' => 'c8e7583ae55127b89d6915480ce295bac81c4f88'), 'clue/ndjson-react' => array('pretty_version' => 'v1.1.0', 'version' => '1.1.0.0', 'aliases' => array(), 'reference' => '767ec9543945802b5766fab0da4520bf20626f66'), 'composer/ca-bundle' => array('pretty_version' => '1.2.8', 'version' => '1.2.8.0', 'aliases' => array(), 'reference' => '8a7ecad675253e4654ea05505233285377405215'), 'composer/package-versions-deprecated' => array('pretty_version' => '1.11.99.1', 'version' => '1.11.99.1', 'aliases' => array(), 'reference' => '7413f0b55a051e89485c5cb9f765fe24bb02a7b6'), 'composer/xdebug-handler' => array('pretty_version' => '1.4.5', 'version' => '1.4.5.0', 'aliases' => array(), 'reference' => 'f28d44c286812c714741478d968104c5e604a1d4'), 'doctrine/annotations' => array('pretty_version' => '1.11.1', 'version' => '1.11.1.0', 'aliases' => array(), 'reference' => 'ce77a7ba1770462cd705a91a151b6c3746f9c6ad'), 'doctrine/inflector' => array('pretty_version' => '2.0.3', 'version' => '2.0.3.0', 'aliases' => array(), 'reference' => '9cf661f4eb38f7c881cac67c75ea9b00bf97b210'), 'doctrine/lexer' => array('pretty_version' => '1.2.1', 'version' => '1.2.1.0', 'aliases' => array(), 'reference' => 'e864bbf5904cb8f5bb334f99209b48018522f042'), 'evenement/evenement' => array('pretty_version' => 'v3.0.1', 'version' => '3.0.1.0', 'aliases' => array(), 'reference' => '531bfb9d15f8aa57454f5f0285b18bec903b8fb7'), 'hoa/compiler' => array('pretty_version' => '3.17.08.08', 'version' => '3.17.08.08', 'aliases' => array(), 'reference' => 'aa09caf0bf28adae6654ca6ee415ee2f522672de'), 'hoa/consistency' => array('pretty_version' => '1.17.05.02', 'version' => '1.17.05.02', 'aliases' => array(), 'reference' => 'fd7d0adc82410507f332516faf655b6ed22e4c2f'), 'hoa/event' => array('pretty_version' => '1.17.01.13', 'version' => '1.17.01.13', 'aliases' => array(), 'reference' => '6c0060dced212ffa3af0e34bb46624f990b29c54'), 'hoa/exception' => array('pretty_version' => '1.17.01.16', 'version' => '1.17.01.16', 'aliases' => array(), 'reference' => '091727d46420a3d7468ef0595651488bfc3a458f'), 'hoa/file' => array('pretty_version' => '1.17.07.11', 'version' => '1.17.07.11', 'aliases' => array(), 'reference' => '35cb979b779bc54918d2f9a4e02ed6c7a1fa67ca'), 'hoa/iterator' => array('pretty_version' => '2.17.01.10', 'version' => '2.17.01.10', 'aliases' => array(), 'reference' => 'd1120ba09cb4ccd049c86d10058ab94af245f0cc'), 'hoa/math' => array('pretty_version' => '1.17.05.16', 'version' => '1.17.05.16', 'aliases' => array(), 'reference' => '7150785d30f5d565704912116a462e9f5bc83a0c'), 'hoa/protocol' => array('pretty_version' => '1.17.01.14', 'version' => '1.17.01.14', 'aliases' => array(), 'reference' => '5c2cf972151c45f373230da170ea015deecf19e2'), 'hoa/regex' => array('pretty_version' => '1.17.01.13', 'version' => '1.17.01.13', 'aliases' => array(), 'reference' => '7e263a61b6fb45c1d03d8e5ef77668518abd5bec'), 'hoa/stream' => array('pretty_version' => '1.17.02.21', 'version' => '1.17.02.21', 'aliases' => array(), 'reference' => '3293cfffca2de10525df51436adf88a559151d82'), 'hoa/ustring' => array('pretty_version' => '4.17.01.16', 'version' => '4.17.01.16', 'aliases' => array(), 'reference' => 'e6326e2739178799b1fe3fdd92029f9517fa17a0'), 'hoa/visitor' => array('pretty_version' => '2.17.01.16', 'version' => '2.17.01.16', 'aliases' => array(), 'reference' => 'c18fe1cbac98ae449e0d56e87469103ba08f224a'), 'hoa/zformat' => array('pretty_version' => '1.17.01.10', 'version' => '1.17.01.10', 'aliases' => array(), 'reference' => '522c381a2a075d4b9dbb42eb4592dd09520e4ac2'), 'jean85/pretty-package-versions' => array('pretty_version' => '1.5.1', 'version' => '1.5.1.0', 'aliases' => array(), 'reference' => 'a917488320c20057da87f67d0d40543dd9427f7a'), 'jetbrains/phpstorm-stubs' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9999999-dev'), 'reference' => '05d145c0bbafcf9a551fdd8824adb2a7e259fdaf'), 'nette/bootstrap' => array('pretty_version' => 'v3.0.2', 'version' => '3.0.2.0', 'aliases' => array(), 'reference' => '67830a65b42abfb906f8e371512d336ebfb5da93'), 'nette/di' => array('pretty_version' => 'v3.0.6', 'version' => '3.0.6.0', 'aliases' => array(), 'reference' => 'e639ccfbc0230e022ca08bf59c6b07df7caf2007'), 'nette/finder' => array('pretty_version' => 'v2.5.2', 'version' => '2.5.2.0', 'aliases' => array(), 'reference' => '4ad2c298eb8c687dd0e74ae84206a4186eeaed50'), 'nette/neon' => array('pretty_version' => 'v3.2.1', 'version' => '3.2.1.0', 'aliases' => array(), 'reference' => 'a5b3a60833d2ef55283a82d0c30b45d136b29e75'), 'nette/php-generator' => array('pretty_version' => 'v3.5.1', 'version' => '3.5.1.0', 'aliases' => array(), 'reference' => 'fe54415cd22d01bee1307a608058bf131978610a'), 'nette/robot-loader' => array('pretty_version' => 'v3.3.1', 'version' => '3.3.1.0', 'aliases' => array(), 'reference' => '15c1ecd0e6e69e8d908dfc4cca7b14f3b850a96b'), 'nette/schema' => array('pretty_version' => 'v1.0.3', 'version' => '1.0.3.0', 'aliases' => array(), 'reference' => '34baf9eca75eccdad3d04306c5d6bec0f6b252ad'), 'nette/utils' => array('pretty_version' => 'v3.2.0', 'version' => '3.2.0.0', 'aliases' => array(), 'reference' => 'd0427c1811462dbb6c503143eabe5478b26685f7'), 'nikic/php-parser' => array('pretty_version' => 'v4.10.2', 'version' => '4.10.2.0', 'aliases' => array(), 'reference' => '658f1be311a230e0907f5dfe0213742aff0596de'), 'ocramius/package-versions' => array('replaced' => array(0 => '1.11.99')), 'ondram/ci-detector' => array('pretty_version' => '3.5.1', 'version' => '3.5.1.0', 'aliases' => array(), 'reference' => '594e61252843b68998bddd48078c5058fe9028bd'), 'ondrejmirtes/better-reflection' => array('pretty_version' => '4.3.45', 'version' => '4.3.45.0', 'aliases' => array(), 'reference' => '3a559356763161db915cfa775b34cffe4f2c5905'), 'phpdocumentor/reflection-common' => array('pretty_version' => '2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '1d01c49d4ed62f25aa84a747ad35d5a16924662b'), 'phpdocumentor/reflection-docblock' => array('pretty_version' => '4.3.4', 'version' => '4.3.4.0', 'aliases' => array(), 'reference' => 'da3fd972d6bafd628114f7e7e036f45944b62e9c'), 'phpdocumentor/type-resolver' => array('pretty_version' => '1.4.0', 'version' => '1.4.0.0', 'aliases' => array(), 'reference' => '6a467b8989322d92aa1c8bf2bebcc6e5c2ba55c0'), 'phpstan/php-8-stubs' => array('pretty_version' => '0.1.9', 'version' => '0.1.9.0', 'aliases' => array(), 'reference' => 'c6d1a53f65c38e0f356cc4e380716eceff857e58'), 'phpstan/phpdoc-parser' => array('pretty_version' => '0.4.9', 'version' => '0.4.9.0', 'aliases' => array(), 'reference' => '98a088b17966bdf6ee25c8a4b634df313d8aa531'), 'phpstan/phpstan' => array('replaced' => array(0 => '0.12.57')), 'phpstan/phpstan-phpunit' => array('pretty_version' => '0.12.16', 'version' => '0.12.16.0', 'aliases' => array(), 'reference' => '1dd916d181b0539dea5cd37e91546afb8b107e17'), 'phpstan/phpstan-src' => array('pretty_version' => '0.12.57', 'version' => '0.12.57.0', 'aliases' => array(), 'reference' => 'b5a2fe2120e58bba9b28b8b3cc8fd3b823691344'), 'psr/cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => 'd11b50ad223250cf17b86e38383413f5a6764bf8'), 'psr/cache-implementation' => array('provided' => array(0 => '1.0')), 'psr/container' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'b7ce3b176482dbbc1245ebf52b181af44c2cf55f'), 'psr/container-implementation' => array('provided' => array(0 => '1.0')), 'psr/event-dispatcher-implementation' => array('provided' => array(0 => '1.0')), 'psr/http-message' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => 'f6561bf28d520154e4b0ec72be95418abe6d9363'), 'psr/http-message-implementation' => array('provided' => array(0 => '1.0')), 'psr/log' => array('pretty_version' => '1.1.3', 'version' => '1.1.3.0', 'aliases' => array(), 'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc'), 'psr/log-implementation' => array('provided' => array(0 => '1.0')), 'psr/simple-cache' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b'), 'psr/simple-cache-implementation' => array('provided' => array(0 => '1.0')), 'react/cache' => array('pretty_version' => 'v1.1.0', 'version' => '1.1.0.0', 'aliases' => array(), 'reference' => '44a568925556b0bd8cacc7b49fb0f1cf0d706a0c'), 'react/child-process' => array('pretty_version' => 'v0.6.1', 'version' => '0.6.1.0', 'aliases' => array(), 'reference' => '6895afa583d51dc10a4b9e93cd3bce17b3b77ac3'), 'react/dns' => array('pretty_version' => 'v1.4.0', 'version' => '1.4.0.0', 'aliases' => array(), 'reference' => '665260757171e2ab17485b44e7ffffa7acb6ca1f'), 'react/event-loop' => array('pretty_version' => 'v1.1.1', 'version' => '1.1.1.0', 'aliases' => array(), 'reference' => '6d24de090cd59cfc830263cfba965be77b563c13'), 'react/http' => array('pretty_version' => 'v1.1.0', 'version' => '1.1.0.0', 'aliases' => array(), 'reference' => '754b0c18545d258922ffa907f3b18598280fdecd'), 'react/promise' => array('pretty_version' => 'v2.8.0', 'version' => '2.8.0.0', 'aliases' => array(), 'reference' => 'f3cff96a19736714524ca0dd1d4130de73dbbbc4'), 'react/promise-stream' => array('pretty_version' => 'v1.2.0', 'version' => '1.2.0.0', 'aliases' => array(), 'reference' => '6384d8b76cf7dcc44b0bf3343fb2b2928412d1fe'), 'react/promise-timer' => array('pretty_version' => 'v1.6.0', 'version' => '1.6.0.0', 'aliases' => array(), 'reference' => 'daee9baf6ef30c43ea4c86399f828bb5f558f6e6'), 'react/socket' => array('pretty_version' => 'v1.6.0', 'version' => '1.6.0.0', 'aliases' => array(), 'reference' => 'e2b96b23a13ca9b41ab343268dbce3f8ef4d524a'), 'react/stream' => array('pretty_version' => 'v1.1.1', 'version' => '1.1.1.0', 'aliases' => array(), 'reference' => '7c02b510ee3f582c810aeccd3a197b9c2f52ff1a'), 'rector/rector' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => 'c6f6b79749f54c3f3a556130dd3e33beda787805'), 'rector/rector-prefixed' => array('replaced' => array(0 => 'dev-master')), 'rector/simple-php-doc-parser' => array('replaced' => array(0 => 'dev-master')), 'rector/symfony-php-config' => array('replaced' => array(0 => 'dev-master')), 'ringcentral/psr7' => array('pretty_version' => '1.3.0', 'version' => '1.3.0.0', 'aliases' => array(), 'reference' => '360faaec4b563958b673fb52bbe94e37f14bc686'), 'roave/signature' => array('pretty_version' => '1.1.0', 'version' => '1.1.0.0', 'aliases' => array(), 'reference' => 'c4e8a59946bad694ab5682a76e7884a9157a8a2c'), 'sebastian/diff' => array('pretty_version' => '4.0.4', 'version' => '4.0.4.0', 'aliases' => array(), 'reference' => '3461e3fccc7cfdfc2720be910d3bd73c69be590d'), 'symfony/cache' => array('pretty_version' => 'v5.1.8', 'version' => '5.1.8.0', 'aliases' => array(), 'reference' => 'd7bc33e9f9028f49f87057e7944c076d9593f046'), 'symfony/cache-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '8034ca0b61d4dd967f3698aaa1da2507b631d0cb'), 'symfony/cache-implementation' => array('provided' => array(0 => '1.0')), 'symfony/config' => array('pretty_version' => 'v5.1.8', 'version' => '5.1.8.0', 'aliases' => array(), 'reference' => '11baeefa4c179d6908655a7b6be728f62367c193'), 'symfony/console' => array('pretty_version' => 'v4.4.16', 'version' => '4.4.16.0', 'aliases' => array(), 'reference' => '20f73dd143a5815d475e0838ff867bce1eebd9d5'), 'symfony/debug' => array('pretty_version' => 'v4.4.16', 'version' => '4.4.16.0', 'aliases' => array(), 'reference' => 'c87adf3fc1cd0bf4758316a3a150d50a8f957ef4'), 'symfony/dependency-injection' => array('pretty_version' => 'v5.1.8', 'version' => '5.1.8.0', 'aliases' => array(), 'reference' => '829ca6bceaf68036a123a13a979f3c89289eae78'), 'symfony/deprecation-contracts' => array('pretty_version' => 'v2.2.0', 'version' => '2.2.0.0', 'aliases' => array(), 'reference' => '5fa56b4074d1ae755beb55617ddafe6f5d78f665'), 'symfony/error-handler' => array('pretty_version' => 'v4.4.16', 'version' => '4.4.16.0', 'aliases' => array(), 'reference' => '363cca01cabf98e4f1c447b14d0a68617f003613'), 'symfony/event-dispatcher' => array('pretty_version' => 'v4.4.16', 'version' => '4.4.16.0', 'aliases' => array(), 'reference' => '4204f13d2d0b7ad09454f221bb2195fccdf1fe98'), 'symfony/event-dispatcher-contracts' => array('pretty_version' => 'v1.1.9', 'version' => '1.1.9.0', 'aliases' => array(), 'reference' => '84e23fdcd2517bf37aecbd16967e83f0caee25a7'), 'symfony/event-dispatcher-implementation' => array('provided' => array(0 => '1.1')), 'symfony/filesystem' => array('pretty_version' => 'v5.1.8', 'version' => '5.1.8.0', 'aliases' => array(), 'reference' => 'df08650ea7aee2d925380069c131a66124d79177'), 'symfony/finder' => array('pretty_version' => 'v4.4.16', 'version' => '4.4.16.0', 'aliases' => array(), 'reference' => '26f63b8d4e92f2eecd90f6791a563ebb001abe31'), 'symfony/http-client-contracts' => array('pretty_version' => 'v2.3.1', 'version' => '2.3.1.0', 'aliases' => array(), 'reference' => '41db680a15018f9c1d4b23516059633ce280ca33'), 'symfony/http-foundation' => array('pretty_version' => 'v5.1.8', 'version' => '5.1.8.0', 'aliases' => array(), 'reference' => 'a2860ec970404b0233ab1e59e0568d3277d32b6f'), 'symfony/http-kernel' => array('pretty_version' => 'v4.4.16', 'version' => '4.4.16.0', 'aliases' => array(), 'reference' => '109b2a46e470a487ec8b0ffea4b0bb993aaf42ed'), 'symfony/polyfill-ctype' => array('pretty_version' => 'v1.20.0', 'version' => '1.20.0.0', 'aliases' => array(), 'reference' => 'f4ba089a5b6366e453971d3aad5fe8e897b37f41'), 'symfony/polyfill-mbstring' => array('pretty_version' => 'v1.20.0', 'version' => '1.20.0.0', 'aliases' => array(), 'reference' => '39d483bdf39be819deabf04ec872eb0b2410b531'), 'symfony/polyfill-php73' => array('pretty_version' => 'v1.20.0', 'version' => '1.20.0.0', 'aliases' => array(), 'reference' => '8ff431c517be11c78c48a39a66d37431e26a6bed'), 'symfony/polyfill-php80' => array('pretty_version' => 'v1.20.0', 'version' => '1.20.0.0', 'aliases' => array(), 'reference' => 'e70aa8b064c5b72d3df2abd5ab1e90464ad009de'), 'symfony/process' => array('pretty_version' => 'v5.1.8', 'version' => '5.1.8.0', 'aliases' => array(), 'reference' => 'f00872c3f6804150d6a0f73b4151daab96248101'), 'symfony/service-contracts' => array('pretty_version' => 'v1.1.8', 'version' => '1.1.8.0', 'aliases' => array(), 'reference' => 'ffc7f5692092df31515df2a5ecf3b7302b3ddacf'), 'symfony/service-implementation' => array('provided' => array(0 => '1.0')), 'symfony/var-dumper' => array('pretty_version' => 'v5.1.8', 'version' => '5.1.8.0', 'aliases' => array(), 'reference' => '4e13f3fcefb1fcaaa5efb5403581406f4e840b9a'), 'symfony/var-exporter' => array('pretty_version' => 'v5.1.8', 'version' => '5.1.8.0', 'aliases' => array(), 'reference' => 'b4048bfc6248413592462c029381bdb2f7b6525f'), 'symfony/yaml' => array('pretty_version' => 'v5.1.8', 'version' => '5.1.8.0', 'aliases' => array(), 'reference' => 'f284e032c3cefefb9943792132251b79a6127ca6'), 'symplify/autowire-array-parameter' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '6b042921db122d88e0653f031ee75f4bdfd747f5'), 'symplify/composer-json-manipulator' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => 'c508eb786847182d8c61ab78e2771e349fb2fa49'), 'symplify/console-color-diff' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '9c6fc82326bec1f66ec51ade944d11a82fe9bd65'), 'symplify/easy-testing' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => 'c223941033bd9837389f4023ee9940e9af8a5908'), 'symplify/markdown-diff' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '1ae7e14a9f07eac3d8fe5a1bcdab509de12cf52c'), 'symplify/package-builder' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => 'ac3f4c7f09f740de4f9ddae802a6efe765520fbb'), 'symplify/php-config-printer' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => 'babeccc0296f01fa7b1687d8078cb4bc78216e7b'), 'symplify/rule-doc-generator' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '816fcba95324146e0087f7e3d3a9449a4567c2de'), 'symplify/set-config-resolver' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => 'e3382b1a8cf1961a61869aa636e947ccd58dd610'), 'symplify/skipper' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '45e0b215e9b25201b8ef2ae441eee58f327f18a7'), 'symplify/smart-file-system' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '9e158ca902e75bc7b74b099f35175d535bb5fc06'), 'symplify/symplify-kernel' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '9934bcd07574ee0ebc68b0b7b240323999c29831'), 'webmozart/assert' => array('pretty_version' => '1.9.1', 'version' => '1.9.1.0', 'aliases' => array(), 'reference' => 'bafc69caeb4d49c39fd0779086c03a3738cbb389')));
    public static function getInstalledPackages()
    {
        return \array_keys(self::$installed['versions']);
    }
    public static function isInstalled($packageName)
    {
        return isset(self::$installed['versions'][$packageName]);
    }
    public static function satisfies(\_PhpScoper88fe6e0ad041\Composer\Semver\VersionParser $parser, $packageName, $constraint)
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