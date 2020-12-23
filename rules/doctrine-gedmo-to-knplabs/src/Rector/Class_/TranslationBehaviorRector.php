<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LocaleTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TranslatableTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/translatable.md
 * @see https://github.com/KnpLabs/DoctrineBehaviors/blob/4e0677379dd4adf84178f662d08454a9627781a8/docs/translatable.md
 *
 * @see https://lab.axioma.lv/symfony2/pagebundle/commit/062f9f87add5740ea89072e376dd703f3188d2ce
 *
 * @see \Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\TranslationBehaviorRector\TranslationBehaviorRectorTest
 */
final class TranslationBehaviorRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator)
    {
        $this->classManipulator = $classManipulator;
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Translation from gedmo/doctrine-extensions to knplabs/doctrine-behaviors', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Table
 */
class Article implements Translatable
{
    /**
     * @Gedmo\Translatable
     * @ORM\Column(length=128)
     */
    private $title;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     * and it is not necessary because globally locale can be set in listener
     */
    private $locale;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;

class SomeClass implements TranslatableInterface
{
    use TranslatableTrait;
}


use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

class SomeClassTranslation implements TranslationInterface
{
    use TranslationTrait;

    /**
     * @ORM\Column(length=128)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->classManipulator->hasInterface($node, '_PhpScoper0a2ac50786fa\\Gedmo\\Translatable\\Translatable')) {
            return null;
        }
        $this->classManipulator->removeInterface($node, '_PhpScoper0a2ac50786fa\\Gedmo\\Translatable\\Translatable');
        // 1. replace trait
        $this->classInsertManipulator->addAsFirstTrait($node, '_PhpScoper0a2ac50786fa\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait');
        // 2. add interface
        $node->implements[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified('_PhpScoper0a2ac50786fa\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface');
        $removedPropertyNameToPhpDocInfo = $this->collectAndRemoveTranslatableProperties($node);
        $removePropertyNames = \array_keys($removedPropertyNameToPhpDocInfo);
        $this->removeSetAndGetMethods($node, $removePropertyNames);
        $this->dumpEntityTranslation($node, $removedPropertyNameToPhpDocInfo);
        return $node;
    }
    /**
     * @return PhpDocInfo[]
     */
    private function collectAndRemoveTranslatableProperties(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $removedPropertyNameToPhpDocInfo = [];
        foreach ($class->getProperties() as $property) {
            $propertyPhpDocInfo = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($propertyPhpDocInfo === null) {
                continue;
            }
            $hasTypeLocaleTagValueNode = $propertyPhpDocInfo->hasByType(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\LocaleTagValueNode::class);
            if ($hasTypeLocaleTagValueNode) {
                $this->removeNode($property);
                continue;
            }
            $hasTypeTranslatableTagValueNode = $propertyPhpDocInfo->hasByType(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TranslatableTagValueNode::class);
            if (!$hasTypeTranslatableTagValueNode) {
                continue;
            }
            $propertyPhpDocInfo->removeByType(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\TranslatableTagValueNode::class);
            $propertyName = $this->getName($property);
            $removedPropertyNameToPhpDocInfo[$propertyName] = $propertyPhpDocInfo;
            $this->removeNode($property);
        }
        return $removedPropertyNameToPhpDocInfo;
    }
    /**
     * @param string[] $removedPropertyNames
     */
    private function removeSetAndGetMethods(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, array $removedPropertyNames) : void
    {
        foreach ($removedPropertyNames as $removedPropertyName) {
            foreach ($class->getMethods() as $classMethod) {
                if ($this->isName($classMethod, 'set' . \ucfirst($removedPropertyName))) {
                    $this->removeNode($classMethod);
                }
                if ($this->isName($classMethod, 'get' . \ucfirst($removedPropertyName))) {
                    $this->removeNode($classMethod);
                }
                if ($this->isName($classMethod, 'setTranslatableLocale')) {
                    $this->removeNode($classMethod);
                }
            }
        }
    }
    /**
     * @param PhpDocInfo[] $translatedPropertyToPhpDocInfos
     */
    private function dumpEntityTranslation(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, array $translatedPropertyToPhpDocInfos) : void
    {
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $class->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        $classShortName = $class->name . 'Translation';
        $filePath = \dirname($fileInfo->getRealPath()) . \DIRECTORY_SEPARATOR . $classShortName . '.php';
        $namespace = $class->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$namespace instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        $namespace = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_($namespace->name);
        $class = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_($classShortName);
        $class->implements[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified('_PhpScoper0a2ac50786fa\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface');
        $this->classInsertManipulator->addAsFirstTrait($class, '_PhpScoper0a2ac50786fa\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait');
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($class);
        $phpDocInfo->addTagValueNodeWithShortName(new \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode([]));
        foreach ($translatedPropertyToPhpDocInfos as $translatedPropertyName => $translatedPhpDocInfo) {
            $property = $this->nodeFactory->createPrivateProperty($translatedPropertyName);
            $property->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $translatedPhpDocInfo);
            $class->stmts[] = $property;
        }
        $namespace->stmts[] = $class;
        $this->printToFile([$namespace], $filePath);
    }
}
