<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner;

use RectorPrefix2020DecSat\Symfony\Component\VarDumper\Caster\Caster;
use RectorPrefix2020DecSat\Symfony\Component\VarDumper\Exception\ThrowingCasterException;
/**
 * AbstractCloner implements a generic caster mechanism for objects and resources.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractCloner implements \RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner\ClonerInterface
{
    public static $defaultCasters = ['__PHP_Incomplete_Class' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\Caster', 'castPhpIncompleteClass'], 'RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\CutStub' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castStub'], 'RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\CutArrayStub' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castCutArray'], 'RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ConstStub' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castStub'], 'RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\EnumStub' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castEnum'], 'Closure' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClosure'], 'Generator' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castGenerator'], 'ReflectionType' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castType'], 'ReflectionAttribute' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castAttribute'], 'ReflectionGenerator' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castReflectionGenerator'], 'ReflectionClass' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClass'], 'ReflectionClassConstant' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClassConstant'], 'ReflectionFunctionAbstract' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castFunctionAbstract'], 'ReflectionMethod' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castMethod'], 'ReflectionParameter' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castParameter'], 'ReflectionProperty' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castProperty'], 'ReflectionReference' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castReference'], 'ReflectionExtension' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castExtension'], 'ReflectionZendExtension' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castZendExtension'], 'RectorPrefix2020DecSat\\Doctrine\\Common\\Persistence\\ObjectManager' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'RectorPrefix2020DecSat\\Doctrine\\Common\\Proxy\\Proxy' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castCommonProxy'], 'RectorPrefix2020DecSat\\Doctrine\\ORM\\Proxy\\Proxy' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castOrmProxy'], 'RectorPrefix2020DecSat\\Doctrine\\ORM\\PersistentCollection' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castPersistentCollection'], 'RectorPrefix2020DecSat\\Doctrine\\Persistence\\ObjectManager' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'DOMException' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castException'], 'DOMStringList' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNameList' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMImplementation' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castImplementation'], 'DOMImplementationList' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNode' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNode'], 'DOMNameSpaceNode' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNameSpaceNode'], 'DOMDocument' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDocument'], 'DOMNodeList' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNamedNodeMap' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMCharacterData' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castCharacterData'], 'DOMAttr' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castAttr'], 'DOMElement' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castElement'], 'DOMText' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castText'], 'DOMTypeinfo' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castTypeinfo'], 'DOMDomError' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDomError'], 'DOMLocator' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLocator'], 'DOMDocumentType' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDocumentType'], 'DOMNotation' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNotation'], 'DOMEntity' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castEntity'], 'DOMProcessingInstruction' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castProcessingInstruction'], 'DOMXPath' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castXPath'], 'XMLReader' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\XmlReaderCaster', 'castXmlReader'], 'ErrorException' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castErrorException'], 'Exception' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castException'], 'Error' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castError'], 'RectorPrefix2020DecSat\\Symfony\\Bridge\\Monolog\\Logger' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'RectorPrefix2020DecSat\\Symfony\\Component\\DependencyInjection\\ContainerInterface' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'RectorPrefix2020DecSat\\Symfony\\Component\\EventDispatcher\\EventDispatcherInterface' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpClient\\CurlHttpClient' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClient'], 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpClient\\NativeHttpClient' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClient'], 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpClient\\Response\\CurlResponse' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClientResponse'], 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpClient\\Response\\NativeResponse' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClientResponse'], 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpFoundation\\Request' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castRequest'], 'RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Exception\\ThrowingCasterException' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castThrowingCasterException'], 'RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\TraceStub' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castTraceStub'], 'RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\FrameStub' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castFrameStub'], 'RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Cloner\\AbstractCloner' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'RectorPrefix2020DecSat\\Symfony\\Component\\ErrorHandler\\Exception\\SilencedErrorContext' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castSilencedErrorContext'], 'RectorPrefix2020DecSat\\Imagine\\Image\\ImageInterface' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ImagineCaster', 'castImage'], 'RectorPrefix2020DecSat\\Ramsey\\Uuid\\UuidInterface' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\UuidCaster', 'castRamseyUuid'], 'RectorPrefix2020DecSat\\ProxyManager\\Proxy\\ProxyInterface' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ProxyManagerCaster', 'castProxy'], 'PHPUnit_Framework_MockObject_MockObject' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'RectorPrefix2020DecSat\\PHPUnit\\Framework\\MockObject\\MockObject' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'RectorPrefix2020DecSat\\PHPUnit\\Framework\\MockObject\\Stub' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'RectorPrefix2020DecSat\\Prophecy\\Prophecy\\ProphecySubjectInterface' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'RectorPrefix2020DecSat\\Mockery\\MockInterface' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'PDO' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\PdoCaster', 'castPdo'], 'PDOStatement' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\PdoCaster', 'castPdoStatement'], 'AMQPConnection' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castConnection'], 'AMQPChannel' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castChannel'], 'AMQPQueue' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castQueue'], 'AMQPExchange' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castExchange'], 'AMQPEnvelope' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castEnvelope'], 'ArrayObject' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castArrayObject'], 'ArrayIterator' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castArrayIterator'], 'SplDoublyLinkedList' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castDoublyLinkedList'], 'SplFileInfo' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castFileInfo'], 'SplFileObject' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castFileObject'], 'SplHeap' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castHeap'], 'SplObjectStorage' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castObjectStorage'], 'SplPriorityQueue' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castHeap'], 'OuterIterator' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castOuterIterator'], 'WeakReference' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castWeakReference'], 'Redis' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedis'], 'RedisArray' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedisArray'], 'RedisCluster' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedisCluster'], 'DateTimeInterface' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castDateTime'], 'DateInterval' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castInterval'], 'DateTimeZone' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castTimeZone'], 'DatePeriod' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castPeriod'], 'GMP' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\GmpCaster', 'castGmp'], 'MessageFormatter' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castMessageFormatter'], 'NumberFormatter' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castNumberFormatter'], 'IntlTimeZone' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlTimeZone'], 'IntlCalendar' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlCalendar'], 'IntlDateFormatter' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlDateFormatter'], 'Memcached' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\MemcachedCaster', 'castMemcached'], 'RectorPrefix2020DecSat\\Ds\\Collection' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castCollection'], 'RectorPrefix2020DecSat\\Ds\\Map' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castMap'], 'RectorPrefix2020DecSat\\Ds\\Pair' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castPair'], 'RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DsPairStub' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castPairStub'], 'CurlHandle' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castCurl'], ':curl' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castCurl'], ':dba' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castDba'], ':dba persistent' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castDba'], 'GdImage' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castGd'], ':gd' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castGd'], ':mysql link' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castMysqlLink'], ':pgsql large object' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLargeObject'], ':pgsql link' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLink'], ':pgsql link persistent' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLink'], ':pgsql result' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castResult'], ':process' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castProcess'], ':stream' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStream'], 'OpenSSLCertificate' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castOpensslX509'], ':OpenSSL X.509' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castOpensslX509'], ':persistent stream' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStream'], ':stream-context' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStreamContext'], 'XmlParser' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\XmlResourceCaster', 'castXml'], ':xml' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\XmlResourceCaster', 'castXml'], 'RdKafka' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castRdKafka'], 'RectorPrefix2020DecSat\\RdKafka\\Conf' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castConf'], 'RectorPrefix2020DecSat\\RdKafka\\KafkaConsumer' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castKafkaConsumer'], 'RectorPrefix2020DecSat\\RdKafka\\Metadata\\Broker' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castBrokerMetadata'], 'RectorPrefix2020DecSat\\RdKafka\\Metadata\\Collection' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castCollectionMetadata'], 'RectorPrefix2020DecSat\\RdKafka\\Metadata\\Partition' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castPartitionMetadata'], 'RectorPrefix2020DecSat\\RdKafka\\Metadata\\Topic' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicMetadata'], 'RectorPrefix2020DecSat\\RdKafka\\Message' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castMessage'], 'RectorPrefix2020DecSat\\RdKafka\\Topic' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopic'], 'RectorPrefix2020DecSat\\RdKafka\\TopicPartition' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicPartition'], 'RectorPrefix2020DecSat\\RdKafka\\TopicConf' => ['RectorPrefix2020DecSat\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicConf']];
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
            return new \RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner\Data($this->doClone($var));
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
    protected function castObject(\RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
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
            $fileInfo = $r->isInternal() || $r->isSubclassOf(\RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner\Stub::class) ? [] : ['file' => $r->getFileName(), 'line' => $r->getStartLine()];
            $this->classInfo[$class] = [$i, $parents, $hasDebugInfo, $fileInfo];
        }
        $stub->attr += $fileInfo;
        $a = \RectorPrefix2020DecSat\Symfony\Component\VarDumper\Caster\Caster::castObject($obj, $class, $hasDebugInfo, $stub->class);
        try {
            while ($i--) {
                if (!empty($this->casters[$p = $parents[$i]])) {
                    foreach ($this->casters[$p] as $callback) {
                        $a = $callback($obj, $a, $stub, $isNested, $this->filter);
                    }
                }
            }
        } catch (\Exception $e) {
            $a = [(\RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner\Stub::TYPE_OBJECT === $stub->type ? \RectorPrefix2020DecSat\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL : '') . '⚠' => new \RectorPrefix2020DecSat\Symfony\Component\VarDumper\Exception\ThrowingCasterException($e)] + $a;
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
    protected function castResource(\RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
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
            $a = [(\RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner\Stub::TYPE_OBJECT === $stub->type ? \RectorPrefix2020DecSat\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL : '') . '⚠' => new \RectorPrefix2020DecSat\Symfony\Component\VarDumper\Exception\ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
}
