<?php

declare (strict_types=1);
namespace Rector\Generic\Rector\Property;

use _PhpScoper50d83356d739\DI\Annotation\Inject as PHPDIInject;
use _PhpScoper50d83356d739\JMS\DiExtraBundle\Annotation\Inject as JMSInject;
use _PhpScoper50d83356d739\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode;
use Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Exception\NotImplementedException;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Symfony\ServiceMapProvider;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see https://jmsyst.com/bundles/JMSDiExtraBundle/master/annotations#inject
 *
 * @see \Rector\Generic\Tests\Rector\Property\InjectAnnotationClassRector\InjectAnnotationClassRectorTest
 */
final class InjectAnnotationClassRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const ANNOTATION_CLASSES = '$annotationClasses';
    /**
     * @var array<string, string>
     */
    private const ANNOTATION_TO_TAG_CLASS = [\_PhpScoper50d83356d739\DI\Annotation\Inject::class => \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode::class, \_PhpScoper50d83356d739\JMS\DiExtraBundle\Annotation\Inject::class => \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode::class];
    /**
     * @var string
     * @see https://regex101.com/r/pjusUN/1
     */
    private const BETWEEN_PERCENT_CHARS_REGEX = '#%(.*?)%#';
    /**
     * @var string[]
     */
    private $annotationClasses = [];
    /**
     * @var ErrorAndDiffCollector
     */
    private $errorAndDiffCollector;
    /**
     * @var ServiceMapProvider
     */
    private $serviceMapProvider;
    public function __construct(\Rector\Symfony\ServiceMapProvider $serviceMapProvider, \Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector)
    {
        $this->errorAndDiffCollector = $errorAndDiffCollector;
        $this->serviceMapProvider = $serviceMapProvider;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes properties with specified annotations class to constructor injection', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
use JMS\DiExtraBundle\Annotation as DI;

class SomeController
{
    /**
     * @DI\Inject("entity.manager")
     */
    private $entityManager;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use JMS\DiExtraBundle\Annotation as DI;

class SomeController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = entityManager;
    }
}
CODE_SAMPLE
, [self::ANNOTATION_CLASSES => [\_PhpScoper50d83356d739\DI\Annotation\Inject::class, \_PhpScoper50d83356d739\JMS\DiExtraBundle\Annotation\Inject::class]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return null;
        }
        foreach ($this->annotationClasses as $annotationClass) {
            $this->ensureAnnotationClassIsSupported($annotationClass);
            $tagClass = self::ANNOTATION_TO_TAG_CLASS[$annotationClass];
            $injectTagValueNode = $phpDocInfo->getByType($tagClass);
            if ($injectTagValueNode === null) {
                continue;
            }
            if ($this->isParameterInject($injectTagValueNode)) {
                return null;
            }
            $type = $this->resolveType($node, $injectTagValueNode);
            return $this->refactorPropertyWithAnnotation($node, $type, $tagClass);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->annotationClasses = $configuration[self::ANNOTATION_CLASSES] ?? [];
    }
    private function ensureAnnotationClassIsSupported(string $annotationClass) : void
    {
        if (isset(self::ANNOTATION_TO_TAG_CLASS[$annotationClass])) {
            return;
        }
        throw new \Rector\Core\Exception\NotImplementedException(\sprintf('Annotation class "%s" is not implemented yet. Use one of "%s" or add custom tag for it to Rector.', $annotationClass, \implode('", "', \array_keys(self::ANNOTATION_TO_TAG_CLASS))));
    }
    private function isParameterInject(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : bool
    {
        if (!$phpDocTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode) {
            return \false;
        }
        $serviceName = $phpDocTagValueNode->getServiceName();
        if ($serviceName === null) {
            return \false;
        }
        return (bool) \_PhpScoper50d83356d739\Nette\Utils\Strings::match($serviceName, self::BETWEEN_PERCENT_CHARS_REGEX);
    }
    private function resolveType(\PhpParser\Node\Stmt\Property $property, \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : \PHPStan\Type\Type
    {
        if ($phpDocTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode) {
            return $this->resolveJMSDIInjectType($property, $phpDocTagValueNode);
        }
        if ($phpDocTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode) {
            /** @var PhpDocInfo $phpDocInfo */
            $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            return $phpDocInfo->getVarType();
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException();
    }
    private function refactorPropertyWithAnnotation(\PhpParser\Node\Stmt\Property $property, \PHPStan\Type\Type $type, string $tagClass) : ?\PhpParser\Node\Stmt\Property
    {
        if ($type instanceof \PHPStan\Type\MixedType) {
            return null;
        }
        $propertyName = $this->getName($property);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->changeVarType($type);
        $phpDocInfo->removeByType($tagClass);
        $classLike = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->addConstructorDependencyToClass($classLike, $type, $propertyName);
        return $property;
    }
    private function resolveJMSDIInjectType(\PhpParser\Node\Stmt\Property $property, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode $jmsInjectTagValueNode) : \PHPStan\Type\Type
    {
        $serviceMap = $this->serviceMapProvider->provide();
        $serviceName = $jmsInjectTagValueNode->getServiceName();
        if ($serviceName) {
            if (\class_exists($serviceName)) {
                // single class service
                return new \PHPStan\Type\ObjectType($serviceName);
            }
            // 2. service name
            if ($serviceMap->hasService($serviceName)) {
                $serviceType = $serviceMap->getServiceType($serviceName);
                if ($serviceType !== null) {
                    return $serviceType;
                }
            }
        }
        // 3. service is in @var annotation
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $varType = $phpDocInfo->getVarType();
        if (!$varType instanceof \PHPStan\Type\MixedType) {
            return $varType;
        }
        // the @var is missing and service name was not found → report it
        $this->reportServiceNotFound($serviceName, $property);
        return new \PHPStan\Type\MixedType();
    }
    private function reportServiceNotFound(?string $serviceName, \PhpParser\Node\Stmt\Property $property) : void
    {
        if ($serviceName !== null) {
            return;
        }
        /** @var SmartFileInfo $fileInfo */
        $fileInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        $errorMessage = \sprintf('Service "%s" was not found in DI Container of your Symfony App.', $serviceName);
        $this->errorAndDiffCollector->addErrorWithRectorClassMessageAndFileInfo(self::class, $errorMessage, $fileInfo);
    }
}
