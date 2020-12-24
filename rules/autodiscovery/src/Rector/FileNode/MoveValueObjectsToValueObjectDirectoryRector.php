<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Autodiscovery\Rector\FileNode;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\Autodiscovery\Analyzer\ClassAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileNode;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Inspiration @see https://github.com/rectorphp/rector/pull/1865/files#diff-0d18e660cdb626958662641b491623f8
 * @wip
 *
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Autodiscovery\Tests\Rector\FileNode\MoveValueObjectsToValueObjectDirectoryRector\MoveValueObjectsToValueObjectDirectoryRectorTest
 */
final class MoveValueObjectsToValueObjectDirectoryRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const TYPES = 'types';
    /**
     * @var string
     */
    public const SUFFIXES = 'suffixes';
    /**
     * @api
     * @var string
     */
    public const ENABLE_VALUE_OBJECT_GUESSING = '$enableValueObjectGuessing';
    /**
     * @var string[]
     */
    private const COMMON_SERVICE_SUFFIXES = ['Repository', 'Command', 'Mapper', 'Controller', 'Presenter', 'Factory', 'Test', 'TestCase', 'Service'];
    /**
     * @var bool
     */
    private $enableValueObjectGuessing = \true;
    /**
     * @var string[]
     */
    private $types = [];
    /**
     * @var string[]
     */
    private $suffixes = [];
    /**
     * @var ClassAnalyzer
     */
    private $classAnalyzer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Autodiscovery\Analyzer\ClassAnalyzer $classAnalyzer)
    {
        $this->classAnalyzer = $classAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move value object to ValueObject namespace/directory', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
// app/Exception/Name.php
class Name
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// app/ValueObject/Name.php
class Name
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
CODE_SAMPLE
, [self::TYPES => ['ValueObjectInterfaceClassName'], self::SUFFIXES => ['Search'], self::ENABLE_VALUE_OBJECT_GUESSING => \true])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileNode::class];
    }
    /**
     * @param FileNode $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        /** @var Class_|null $class */
        $class = $this->betterNodeFinder->findFirstInstanceOf([$node], \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class);
        if ($class === null) {
            return null;
        }
        if (!$this->isValueObjectMatch($class)) {
            return null;
        }
        $smartFileInfo = $node->getFileInfo();
        $movedFileWithNodes = $this->movedFileWithNodesFactory->createWithDesiredGroup($smartFileInfo, $node->stmts, 'ValueObject');
        if ($movedFileWithNodes === null) {
            return null;
        }
        $this->addMovedFile($movedFileWithNodes);
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->types = $configuration[self::TYPES] ?? [];
        $this->suffixes = $configuration[self::SUFFIXES] ?? [];
        $this->enableValueObjectGuessing = $configuration[self::ENABLE_VALUE_OBJECT_GUESSING] ?? \false;
    }
    private function isValueObjectMatch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($this->isSuffixMatch($class)) {
            return \true;
        }
        $className = $this->getName($class);
        if ($className === null) {
            return \false;
        }
        foreach ($this->types as $type) {
            if (\is_a($className, $type, \true)) {
                return \true;
            }
        }
        if ($this->isKnownServiceType($className)) {
            return \false;
        }
        if (!$this->enableValueObjectGuessing) {
            return \false;
        }
        return $this->classAnalyzer->isValueObjectClass($class);
    }
    private function isSuffixMatch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        $className = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className !== null) {
            foreach ($this->suffixes as $suffix) {
                if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($className, $suffix)) {
                    return \true;
                }
            }
        }
        return \false;
    }
    private function isKnownServiceType(string $className) : bool
    {
        foreach (self::COMMON_SERVICE_SUFFIXES as $commonServiceSuffix) {
            if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($className, $commonServiceSuffix)) {
                return \true;
            }
        }
        return \false;
    }
}
