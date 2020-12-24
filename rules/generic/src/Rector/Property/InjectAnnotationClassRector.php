<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\Property;

use _PhpScopere8e811afab72\DI\Annotation\Inject as PHPDIInject;
use _PhpScopere8e811afab72\JMS\DiExtraBundle\Annotation\Inject as JMSInject;
use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode;
use _PhpScopere8e811afab72\Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Symfony\ServiceMapProvider;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see https://jmsyst.com/bundles/JMSDiExtraBundle/master/annotations#inject
 *
 * @see \Rector\Generic\Tests\Rector\Property\InjectAnnotationClassRector\InjectAnnotationClassRectorTest
 */
final class InjectAnnotationClassRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const ANNOTATION_CLASSES = '$annotationClasses';
    /**
     * @var array<string, string>
     */
    private const ANNOTATION_TO_TAG_CLASS = [\_PhpScopere8e811afab72\DI\Annotation\Inject::class => \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode::class, \_PhpScopere8e811afab72\JMS\DiExtraBundle\Annotation\Inject::class => \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode::class];
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Symfony\ServiceMapProvider $serviceMapProvider, \_PhpScopere8e811afab72\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector)
    {
        $this->errorAndDiffCollector = $errorAndDiffCollector;
        $this->serviceMapProvider = $serviceMapProvider;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes properties with specified annotations class to constructor injection', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::ANNOTATION_CLASSES => [\_PhpScopere8e811afab72\DI\Annotation\Inject::class, \_PhpScopere8e811afab72\JMS\DiExtraBundle\Annotation\Inject::class]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
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
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException(\sprintf('Annotation class "%s" is not implemented yet. Use one of "%s" or add custom tag for it to Rector.', $annotationClass, \implode('", "', \array_keys(self::ANNOTATION_TO_TAG_CLASS))));
    }
    private function isParameterInject(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : bool
    {
        if (!$phpDocTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode) {
            return \false;
        }
        $serviceName = $phpDocTagValueNode->getServiceName();
        if ($serviceName === null) {
            return \false;
        }
        return (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($serviceName, self::BETWEEN_PERCENT_CHARS_REGEX);
    }
    private function resolveType(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($phpDocTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode) {
            return $this->resolveJMSDIInjectType($property, $phpDocTagValueNode);
        }
        if ($phpDocTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode) {
            /** @var PhpDocInfo $phpDocInfo */
            $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            return $phpDocInfo->getVarType();
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
    }
    private function refactorPropertyWithAnnotation(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, \_PhpScopere8e811afab72\PHPStan\Type\Type $type, string $tagClass) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return null;
        }
        $propertyName = $this->getName($property);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->changeVarType($type);
        $phpDocInfo->removeByType($tagClass);
        $classLike = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->addConstructorDependencyToClass($classLike, $type, $propertyName);
        return $property;
    }
    private function resolveJMSDIInjectType(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode $jmsInjectTagValueNode) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $serviceMap = $this->serviceMapProvider->provide();
        $serviceName = $jmsInjectTagValueNode->getServiceName();
        if ($serviceName) {
            if (\class_exists($serviceName)) {
                // single class service
                return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($serviceName);
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
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $varType = $phpDocInfo->getVarType();
        if (!$varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return $varType;
        }
        // the @var is missing and service name was not found → report it
        $this->reportServiceNotFound($serviceName, $property);
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    private function reportServiceNotFound(?string $serviceName, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : void
    {
        if ($serviceName !== null) {
            return;
        }
        /** @var SmartFileInfo $fileInfo */
        $fileInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        $errorMessage = \sprintf('Service "%s" was not found in DI Container of your Symfony App.', $serviceName);
        $this->errorAndDiffCollector->addErrorWithRectorClassMessageAndFileInfo(self::class, $errorMessage, $fileInfo);
    }
}
