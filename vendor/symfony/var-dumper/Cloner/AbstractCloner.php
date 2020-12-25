<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner;

use _PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Caster\Caster;
use _PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Exception\ThrowingCasterException;
/**
 * AbstractCloner implements a generic caster mechanism for objects and resources.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractCloner implements \_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner\ClonerInterface
{
    public static $defaultCasters = ['__PHP_Incomplete_Class' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\Caster', 'castPhpIncompleteClass'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\CutStub' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castStub'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\CutArrayStub' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castCutArray'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ConstStub' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castStub'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\EnumStub' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castEnum'], 'Closure' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClosure'], 'Generator' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castGenerator'], 'ReflectionType' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castType'], 'ReflectionAttribute' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castAttribute'], 'ReflectionGenerator' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castReflectionGenerator'], 'ReflectionClass' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClass'], 'ReflectionClassConstant' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClassConstant'], 'ReflectionFunctionAbstract' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castFunctionAbstract'], 'ReflectionMethod' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castMethod'], 'ReflectionParameter' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castParameter'], 'ReflectionProperty' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castProperty'], 'ReflectionReference' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castReference'], 'ReflectionExtension' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castExtension'], 'ReflectionZendExtension' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castZendExtension'], '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\ObjectManager' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Proxy\\Proxy' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castCommonProxy'], '_PhpScoperbf340cb0be9d\\Doctrine\\ORM\\Proxy\\Proxy' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castOrmProxy'], '_PhpScoperbf340cb0be9d\\Doctrine\\ORM\\PersistentCollection' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castPersistentCollection'], '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\ObjectManager' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'DOMException' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castException'], 'DOMStringList' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNameList' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMImplementation' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castImplementation'], 'DOMImplementationList' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNode' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNode'], 'DOMNameSpaceNode' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNameSpaceNode'], 'DOMDocument' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDocument'], 'DOMNodeList' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNamedNodeMap' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMCharacterData' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castCharacterData'], 'DOMAttr' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castAttr'], 'DOMElement' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castElement'], 'DOMText' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castText'], 'DOMTypeinfo' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castTypeinfo'], 'DOMDomError' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDomError'], 'DOMLocator' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLocator'], 'DOMDocumentType' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDocumentType'], 'DOMNotation' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNotation'], 'DOMEntity' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castEntity'], 'DOMProcessingInstruction' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castProcessingInstruction'], 'DOMXPath' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castXPath'], 'XMLReader' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\XmlReaderCaster', 'castXmlReader'], 'ErrorException' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castErrorException'], 'Exception' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castException'], 'Error' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castError'], '_PhpScoperbf340cb0be9d\\Symfony\\Bridge\\Monolog\\Logger' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\DependencyInjection\\ContainerInterface' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\EventDispatcher\\EventDispatcherInterface' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpClient\\CurlHttpClient' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClient'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpClient\\NativeHttpClient' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClient'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpClient\\Response\\CurlResponse' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClientResponse'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpClient\\Response\\NativeResponse' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClientResponse'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpFoundation\\Request' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castRequest'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Exception\\ThrowingCasterException' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castThrowingCasterException'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\TraceStub' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castTraceStub'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\FrameStub' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castFrameStub'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Cloner\\AbstractCloner' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\ErrorHandler\\Exception\\SilencedErrorContext' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castSilencedErrorContext'], '_PhpScoperbf340cb0be9d\\Imagine\\Image\\ImageInterface' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ImagineCaster', 'castImage'], '_PhpScoperbf340cb0be9d\\Ramsey\\Uuid\\UuidInterface' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\UuidCaster', 'castRamseyUuid'], '_PhpScoperbf340cb0be9d\\ProxyManager\\Proxy\\ProxyInterface' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ProxyManagerCaster', 'castProxy'], 'PHPUnit_Framework_MockObject_MockObject' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], '_PhpScoperbf340cb0be9d\\PHPUnit\\Framework\\MockObject\\MockObject' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], '_PhpScoperbf340cb0be9d\\PHPUnit\\Framework\\MockObject\\Stub' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], '_PhpScoperbf340cb0be9d\\Prophecy\\Prophecy\\ProphecySubjectInterface' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], '_PhpScoperbf340cb0be9d\\Mockery\\MockInterface' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'PDO' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\PdoCaster', 'castPdo'], 'PDOStatement' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\PdoCaster', 'castPdoStatement'], 'AMQPConnection' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castConnection'], 'AMQPChannel' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castChannel'], 'AMQPQueue' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castQueue'], 'AMQPExchange' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castExchange'], 'AMQPEnvelope' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castEnvelope'], 'ArrayObject' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castArrayObject'], 'ArrayIterator' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castArrayIterator'], 'SplDoublyLinkedList' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castDoublyLinkedList'], 'SplFileInfo' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castFileInfo'], 'SplFileObject' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castFileObject'], 'SplHeap' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castHeap'], 'SplObjectStorage' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castObjectStorage'], 'SplPriorityQueue' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castHeap'], 'OuterIterator' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castOuterIterator'], 'WeakReference' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castWeakReference'], 'Redis' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedis'], 'RedisArray' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedisArray'], 'RedisCluster' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedisCluster'], 'DateTimeInterface' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castDateTime'], 'DateInterval' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castInterval'], 'DateTimeZone' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castTimeZone'], 'DatePeriod' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castPeriod'], 'GMP' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\GmpCaster', 'castGmp'], 'MessageFormatter' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castMessageFormatter'], 'NumberFormatter' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castNumberFormatter'], 'IntlTimeZone' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlTimeZone'], 'IntlCalendar' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlCalendar'], 'IntlDateFormatter' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlDateFormatter'], 'Memcached' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\MemcachedCaster', 'castMemcached'], '_PhpScoperbf340cb0be9d\\Ds\\Collection' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castCollection'], '_PhpScoperbf340cb0be9d\\Ds\\Map' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castMap'], '_PhpScoperbf340cb0be9d\\Ds\\Pair' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castPair'], '_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DsPairStub' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castPairStub'], 'CurlHandle' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castCurl'], ':curl' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castCurl'], ':dba' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castDba'], ':dba persistent' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castDba'], 'GdImage' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castGd'], ':gd' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castGd'], ':mysql link' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castMysqlLink'], ':pgsql large object' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLargeObject'], ':pgsql link' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLink'], ':pgsql link persistent' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLink'], ':pgsql result' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castResult'], ':process' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castProcess'], ':stream' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStream'], 'OpenSSLCertificate' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castOpensslX509'], ':OpenSSL X.509' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castOpensslX509'], ':persistent stream' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStream'], ':stream-context' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStreamContext'], 'XmlParser' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\XmlResourceCaster', 'castXml'], ':xml' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\XmlResourceCaster', 'castXml'], 'RdKafka' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castRdKafka'], '_PhpScoperbf340cb0be9d\\RdKafka\\Conf' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castConf'], '_PhpScoperbf340cb0be9d\\RdKafka\\KafkaConsumer' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castKafkaConsumer'], '_PhpScoperbf340cb0be9d\\RdKafka\\Metadata\\Broker' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castBrokerMetadata'], '_PhpScoperbf340cb0be9d\\RdKafka\\Metadata\\Collection' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castCollectionMetadata'], '_PhpScoperbf340cb0be9d\\RdKafka\\Metadata\\Partition' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castPartitionMetadata'], '_PhpScoperbf340cb0be9d\\RdKafka\\Metadata\\Topic' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicMetadata'], '_PhpScoperbf340cb0be9d\\RdKafka\\Message' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castMessage'], '_PhpScoperbf340cb0be9d\\RdKafka\\Topic' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopic'], '_PhpScoperbf340cb0be9d\\RdKafka\\TopicPartition' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicPartition'], '_PhpScoperbf340cb0be9d\\RdKafka\\TopicConf' => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicConf']];
    protected $maxItems = 2500;
    protected $maxString = -1;
    protected $minDepth = 1;
    private $casters = [];
    private $prevErrorHandler;
    private $classInfo = [];
    private $filter = 0;
    /**
     * @param callable[]|null $casters A map of casters
     *
     * @see addCasters
     */
    public function __construct(array $casters = null)
    {
        if (null === $casters) {
            $casters = static::$defaultCasters;
        }
        $this->addCasters($casters);
    }
    /**
     * Adds casters for resources and objects.
     *
     * Maps resources or objects types to a callback.
     * Types are in the key, with a callable caster for value.
     * Resource types are to be prefixed with a `:`,
     * see e.g. static::$defaultCasters.
     *
     * @param callable[] $casters A map of casters
     */
    public function addCasters(array $casters)
    {
        foreach ($casters as $type => $callback) {
            $this->casters[$type][] = $callback;
        }
    }
    /**
     * Sets the maximum number of items to clone past the minimum depth in nested structures.
     */
    public function setMaxItems(int $maxItems)
    {
        $this->maxItems = $maxItems;
    }
    /**
     * Sets the maximum cloned length for strings.
     */
    public function setMaxString(int $maxString)
    {
        $this->maxString = $maxString;
    }
    /**
     * Sets the minimum tree depth where we are guaranteed to clone all the items.  After this
     * depth is reached, only setMaxItems items will be cloned.
     */
    public function setMinDepth(int $minDepth)
    {
        $this->minDepth = $minDepth;
    }
    /**
     * Clones a PHP variable.
     *
     * @param mixed $var    Any PHP variable
     * @param int   $filter A bit field of Caster::EXCLUDE_* constants
     *
     * @return Data The cloned variable represented by a Data object
     */
    public function cloneVar($var, int $filter = 0)
    {
        $this->prevErrorHandler = \set_error_handler(function ($type, $msg, $file, $line, $context = []) {
            if (\E_RECOVERABLE_ERROR === $type || \E_USER_ERROR === $type) {
                // Cloner never dies
                throw new \ErrorException($msg, 0, $type, $file, $line);
            }
            if ($this->prevErrorHandler) {
                return ($this->prevErrorHandler)($type, $msg, $file, $line, $context);
            }
            return \false;
        });
        $this->filter = $filter;
        if ($gc = \gc_enabled()) {
            \gc_disable();
        }
        try {
            return new \_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner\Data($this->doClone($var));
        } finally {
            if ($gc) {
                \gc_enable();
            }
            \restore_error_handler();
            $this->prevErrorHandler = null;
        }
    }
    /**
     * Effectively clones the PHP variable.
     *
     * @param mixed $var Any PHP variable
     *
     * @return array The cloned variable represented in an array
     */
    protected abstract function doClone($var);
    /**
     * Casts an object to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array The object casted as array
     */
    protected function castObject(\_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
    {
        $obj = $stub->value;
        $class = $stub->class;
        if (\PHP_VERSION_ID < 80000 ? "\0" === ($class[15] ?? null) : \false !== \strpos($class, "@anonymous\0")) {
            $stub->class = \get_debug_type($obj);
        }
        if (isset($this->classInfo[$class])) {
            [$i, $parents, $hasDebugInfo, $fileInfo] = $this->classInfo[$class];
        } else {
            $i = 2;
            $parents = [$class];
            $hasDebugInfo = \method_exists($class, '__debugInfo');
            foreach (\class_parents($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            foreach (\class_implements($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            $parents[] = '*';
            $r = new \ReflectionClass($class);
            $fileInfo = $r->isInternal() || $r->isSubclassOf(\_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner\Stub::class) ? [] : ['file' => $r->getFileName(), 'line' => $r->getStartLine()];
            $this->classInfo[$class] = [$i, $parents, $hasDebugInfo, $fileInfo];
        }
        $stub->attr += $fileInfo;
        $a = \_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Caster\Caster::castObject($obj, $class, $hasDebugInfo, $stub->class);
        try {
            while ($i--) {
                if (!empty($this->casters[$p = $parents[$i]])) {
                    foreach ($this->casters[$p] as $callback) {
                        $a = $callback($obj, $a, $stub, $isNested, $this->filter);
                    }
                }
            }
        } catch (\Exception $e) {
            $a = [(\_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner\Stub::TYPE_OBJECT === $stub->type ? \_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL : '') . '⚠' => new \_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Exception\ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
    /**
     * Casts a resource to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array The resource casted as array
     */
    protected function castResource(\_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
    {
        $a = [];
        $res = $stub->value;
        $type = $stub->class;
        try {
            if (!empty($this->casters[':' . $type])) {
                foreach ($this->casters[':' . $type] as $callback) {
                    $a = $callback($res, $a, $stub, $isNested, $this->filter);
                }
            }
        } catch (\Exception $e) {
            $a = [(\_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner\Stub::TYPE_OBJECT === $stub->type ? \_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL : '') . '⚠' => new \_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Exception\ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
}
