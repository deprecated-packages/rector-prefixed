<?php

declare (strict_types=1);
namespace RectorPrefix20210124;

use Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector;
use Rector\Generic\ValueObject\SwapClassMethodArguments;
use Rector\Phalcon\Rector\Assign\FlashWithCssClassesToExtraCallRector;
use Rector\Phalcon\Rector\Assign\NewApplicationToToFactoryWithDefaultContainerRector;
use Rector\Phalcon\Rector\MethodCall\AddRequestToHandleMethodCallRector;
use Rector\Renaming\Rector\ConstFetch\RenameConstantRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use RectorPrefix20210124\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://docs.phalcon.io/4.0/en/upgrade#general-notes
return static function (\RectorPrefix20210124\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # !!! be careful not to run this twice, since it swaps arguments back and forth
    # see https://github.com/rectorphp/rector/issues/2408#issue-534441142
    $services->set(\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::class)->call('configure', [[\Rector\Generic\Rector\StaticCall\SwapClassMethodArgumentsRector::ARGUMENT_SWAPS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\SwapClassMethodArguments('Phalcon\\Model', 'assign', [0, 2, 1])])]]);
    # for class renames is better - https://docs.phalcon.io/4.0/en/upgrade#cheat-sheet
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['Phalcon\\Acl\\Adapter' => 'Phalcon\\Acl\\Adapter\\AbstractAdapter', 'Phalcon\\Acl\\Resource' => 'Phalcon\\Acl\\Component', 'Phalcon\\Acl\\ResourceInterface' => 'Phalcon\\Acl\\ComponentInterface', 'Phalcon\\Acl\\ResourceAware' => 'Phalcon\\Acl\\ComponentAware', 'Phalcon\\Assets\\ResourceInterface' => 'Phalcon\\Assets\\AssetInterface', 'Phalcon\\Validation\\MessageInterface' => 'Phalcon\\Messages\\MessageInterface', 'Phalcon\\Mvc\\Model\\MessageInterface' => 'Phalcon\\Messages\\MessageInterface', 'Phalcon\\Annotations\\Adapter' => 'Phalcon\\Annotations\\Adapter\\AbstractAdapter', 'Phalcon\\Annotations\\Factory' => 'Phalcon\\Annotations\\AnnotationsFactory', 'Phalcon\\Application' => 'Phalcon\\Application\\AbstractApplication', 'Phalcon\\Assets\\Resource' => 'Phalcon\\Assets\\Asset', 'Phalcon\\Assets\\Resource\\Css' => 'Phalcon\\Assets\\Asset\\Css', 'Phalcon\\Assets\\Resource\\Js' => 'Phalcon\\Assets\\Asset\\Js', 'Phalcon\\Cache\\Backend' => 'Phalcon\\Cache', 'Phalcon\\Cache\\Backend\\Factory' => 'Phalcon\\Cache\\AdapterFactory', 'Phalcon\\Cache\\Backend\\Apcu' => 'Phalcon\\Cache\\Adapter\\Apcu', 'Phalcon\\Cache\\Backend\\File' => 'Phalcon\\Cache\\Adapter\\Stream', 'Phalcon\\Cache\\Backend\\Libmemcached' => 'Phalcon\\Cache\\Adapter\\Libmemcached', 'Phalcon\\Cache\\Backend\\Memory' => 'Phalcon\\Cache\\Adapter\\Memory', 'Phalcon\\Cache\\Backend\\Redis' => 'Phalcon\\Cache\\Adapter\\Redis', 'Phalcon\\Cache\\Exception' => 'Phalcon\\Cache\\Exception\\Exception', 'Phalcon\\Config\\Factory' => 'Phalcon\\Config\\ConfigFactory', 'Phalcon\\Db' => 'Phalcon\\Db\\AbstractDb', 'Phalcon\\Db\\Adapter' => 'Phalcon\\Db\\Adapter\\AbstractAdapter', 'Phalcon\\Db\\Adapter\\Pdo' => 'Phalcon\\Db\\Adapter\\Pdo\\AbstractPdo', 'Phalcon\\Db\\Adapter\\Pdo\\Factory' => 'Phalcon\\Db\\Adapter\\PdoFactory', 'Phalcon\\Dispatcher' => 'Phalcon\\Dispatcher\\AbstractDispatcher', 'Phalcon\\Factory' => 'Phalcon\\Factory\\AbstractFactory', 'Phalcon\\Flash' => 'Phalcon\\Flash\\AbstractFlash', 'Phalcon\\Forms\\Element' => 'Phalcon\\Forms\\Element\\AbstractElement', 'Phalcon\\Image\\Adapter' => 'Phalcon\\Image\\Adapter\\AbstractAdapter', 'Phalcon\\Image\\Factory' => 'Phalcon\\Image\\ImageFactory', 'Phalcon\\Logger\\Adapter' => 'Phalcon\\Logger\\Adapter\\AbstractAdapter', 'Phalcon\\Logger\\Adapter\\Blackhole' => 'Phalcon\\Logger\\Adapter\\Noop', 'Phalcon\\Logger\\Adapter\\File' => 'Phalcon\\Logger\\Adapter\\Stream', 'Phalcon\\Logger\\Factory' => 'Phalcon\\Logger\\LoggerFactory', 'Phalcon\\Logger\\Formatter' => 'Phalcon\\Logger\\Formatter\\AbstractFormatter', 'Phalcon\\Mvc\\Collection' => 'Phalcon\\Collection', 'Phalcon\\Mvc\\Collection\\Exception' => 'Phalcon\\Collection\\Exception', 'Phalcon\\Mvc\\Model\\Message' => 'Phalcon\\Messages\\Message', 'Phalcon\\Mvc\\Model\\MetaData\\Files' => 'Phalcon\\Mvc\\Model\\MetaData\\Stream', 'Phalcon\\Mvc\\Model\\Validator' => 'Phalcon\\Validation\\Validator', 'Phalcon\\Mvc\\Model\\Validator\\Email' => 'Phalcon\\Validation\\Validator\\Email', 'Phalcon\\Mvc\\Model\\Validator\\Exclusionin' => 'Phalcon\\Validation\\Validator\\ExclusionIn', 'Phalcon\\Mvc\\Model\\Validator\\Inclusionin' => 'Phalcon\\Validation\\Validator\\InclusionIn', 'Phalcon\\Mvc\\Model\\Validator\\Ip' => 'Phalcon\\Validation\\Validator\\Ip', 'Phalcon\\Mvc\\Model\\Validator\\Numericality' => 'Phalcon\\Validation\\Validator\\Numericality', 'Phalcon\\Mvc\\Model\\Validator\\PresenceOf' => 'Phalcon\\Validation\\Validator\\PresenceOf', 'Phalcon\\Mvc\\Model\\Validator\\Regex' => 'Phalcon\\Validation\\Validator\\Regex', 'Phalcon\\Mvc\\Model\\Validator\\StringLength' => 'Phalcon\\Validation\\Validator\\StringLength', 'Phalcon\\Mvc\\Model\\Validator\\Uniqueness' => 'Phalcon\\Validation\\Validator\\Uniqueness', 'Phalcon\\Mvc\\Model\\Validator\\Url' => 'Phalcon\\Validation\\Validator\\Url', 'Phalcon\\Mvc\\Url' => 'Phalcon\\Url', 'Phalcon\\Mvc\\Url\\Exception' => 'Phalcon\\Url\\Exception', 'Phalcon\\Mvc\\User\\Component' => 'Phalcon\\Di\\Injectable', 'Phalcon\\Mvc\\User\\Module' => 'Phalcon\\Di\\Injectable', 'Phalcon\\Mvc\\User\\Plugin' => 'Phalcon\\Di\\Injectable', 'Phalcon\\Mvc\\View\\Engine' => 'Phalcon\\Mvc\\View\\Engine\\AbstractEngine', 'Phalcon\\Paginator\\Adapter' => 'Phalcon\\Paginator\\Adapter\\AbstractAdapter', 'Phalcon\\Paginator\\Factory' => 'Phalcon\\Paginator\\PaginatorFactory', 'Phalcon\\Session\\Adapter' => 'Phalcon\\Session\\Adapter\\AbstractAdapter', 'Phalcon\\Session\\Adapter\\Files' => 'Phalcon\\Session\\Adapter\\Stream', 'Phalcon\\Session\\Factory' => 'Phalcon\\Session\\Manager', 'Phalcon\\Translate\\Adapter' => 'Phalcon\\Translate\\Adapter\\AbstractAdapter', 'Phalcon\\Translate\\Factory' => 'Phalcon\\Translate\\TranslateFactory', 'Phalcon\\Validation\\CombinedFieldsValidator' => 'Phalcon\\Validation\\AbstractCombinedFieldsValidator', 'Phalcon\\Validation\\Message' => 'Phalcon\\Messages\\Message', 'Phalcon\\Validation\\Message\\Group' => 'Phalcon\\Messages\\Messages', 'Phalcon\\Validation\\Validator' => 'Phalcon\\Validation\\AbstractValidator', 'Phalcon\\Text' => 'Phalcon\\Helper\\Str', 'Phalcon\\Session\\AdapterInterface' => 'SessionHandlerInterface']]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Acl\\AdapterInterface', 'isResource', 'isComponent'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Acl\\AdapterInterface', 'addResource', 'addComponent'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Acl\\AdapterInterface', 'addResourceAccess', 'addComponentAccess'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Acl\\AdapterInterface', 'dropResourceAccess', 'dropComponentAccess'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Acl\\AdapterInterface', 'getActiveResource', 'getActiveComponent'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Acl\\AdapterInterface', 'getResources', 'getComponents'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Acl\\Adapter\\Memory', 'isResource', 'isComponent'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Acl\\Adapter\\Memory', 'addResource', 'addComponent'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Acl\\Adapter\\Memory', 'addResourceAccess', 'addComponentAccess'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Acl\\Adapter\\Memory', 'dropResourceAccess', 'dropComponentAccess'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Acl\\Adapter\\Memory', 'getResources', 'getComponents'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Cli\\Console', 'addModules', 'registerModules'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Dispatcher', 'setModelBinding', 'setModelBinder'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Assets\\Manager', 'addResource', 'addAsset'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Assets\\Manager', 'addResourceByType', 'addAssetByType'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Assets\\Manager', 'collectionResourcesByType', 'collectionAssetsByType'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Http\\RequestInterface', 'isSecureRequest', 'isSecure'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Http\\RequestInterface', 'isSoapRequested', 'isSoap'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Paginator', 'getPaginate', 'paginate'), new \Rector\Renaming\ValueObject\MethodCallRename('Phalcon\\Mvc\\Model\\Criteria', 'order', 'orderBy')])]]);
    $services->set(\Rector\Renaming\Rector\ConstFetch\RenameConstantRector::class)->call('configure', [[\Rector\Renaming\Rector\ConstFetch\RenameConstantRector::OLD_TO_NEW_CONSTANTS => ['FILTER_SPECIAL_CHARS' => 'FILTER_SPECIAL', 'FILTER_ALPHANUM' => 'FILTER_ALNUM']]]);
    $services->set(\Rector\Phalcon\Rector\Assign\FlashWithCssClassesToExtraCallRector::class);
    $services->set(\Rector\Phalcon\Rector\Assign\NewApplicationToToFactoryWithDefaultContainerRector::class);
    $services->set(\Rector\Phalcon\Rector\MethodCall\AddRequestToHandleMethodCallRector::class);
};
