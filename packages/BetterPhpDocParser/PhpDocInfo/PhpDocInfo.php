<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocInfo;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\Annotation\AnnotationNaming;
use Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\ClassNameAwareTagInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use Rector\BetterPhpDocParser\ValueObject\NodeTypes;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\Core\Configuration\CurrentNodeProvider;
use Rector\Core\Exception\NotImplementedYetException;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Util\StaticInstanceOf;
use Rector\StaticTypeMapper\StaticTypeMapper;
/**
 * @template TNode as \PHPStan\PhpDocParser\Ast\Node
 * @see \Rector\Tests\BetterPhpDocParser\PhpDocInfo\PhpDocInfo\PhpDocInfoTest
 */
final class PhpDocInfo
{
    /**
     * @var array<class-string<PhpDocTagValueNode>, string>
     */
    private const TAGS_TYPES_TO_NAMES = [\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class => '@return', \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode::class => '@param', \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class => '@var', \PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueNode::class => '@method', \PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode::class => '@property'];
    /**
     * @var string
     */
    private $originalContent;
    /**
     * @var bool
     */
    private $isSingleLine = \false;
    /**
     * @var mixed[]
     */
    private $tokens = [];
    /**
     * @var PhpDocNode
     */
    private $phpDocNode;
    /**
     * @var PhpDocNode
     */
    private $originalPhpDocNode;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var \PhpParser\Node
     */
    private $node;
    /**
     * @var bool
     */
    private $hasChanged = \false;
    /**
     * @var AnnotationNaming
     */
    private $annotationNaming;
    /**
     * @var CurrentNodeProvider
     */
    private $currentNodeProvider;
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    /**
     * @param mixed[] $tokens
     */
    public function __construct(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, array $tokens, string $originalContent, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \PhpParser\Node $node, \Rector\BetterPhpDocParser\Annotation\AnnotationNaming $annotationNaming, \Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider, \Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector)
    {
        $this->phpDocNode = $phpDocNode;
        $this->tokens = $tokens;
        $this->originalPhpDocNode = clone $phpDocNode;
        $this->originalContent = $originalContent;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->node = $node;
        $this->annotationNaming = $annotationNaming;
        $this->currentNodeProvider = $currentNodeProvider;
        $this->rectorChangeCollector = $rectorChangeCollector;
    }
    public function getOriginalContent() : string
    {
        return $this->originalContent;
    }
    public function addPhpDocTagNode(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode $phpDocChildNode) : void
    {
        $this->phpDocNode->children[] = $phpDocChildNode;
        $this->markAsChanged();
    }
    public function addTagValueNodeWithShortName(\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface $shortNameAwareTag) : void
    {
        $spacelessPhpDocTagNode = new \Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode($shortNameAwareTag->getShortName(), $shortNameAwareTag);
        $this->addPhpDocTagNode($spacelessPhpDocTagNode);
    }
    public function getPhpDocNode() : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        return $this->phpDocNode;
    }
    public function getOriginalPhpDocNode() : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        return $this->originalPhpDocNode;
    }
    /**
     * @return mixed[]
     */
    public function getTokens() : array
    {
        return $this->tokens;
    }
    public function getTokenCount() : int
    {
        return \count($this->tokens);
    }
    public function getVarTagValueNode() : ?\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode
    {
        return $this->phpDocNode->getVarTagValues()[0] ?? null;
    }
    /**
     * @return array<PhpDocTagNode>
     */
    public function getTagsByName(string $name) : array
    {
        $name = $this->annotationNaming->normalizeName($name);
        $tags = $this->phpDocNode->getTags();
        $tags = \array_filter($tags, function (\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode $tag) use($name) : bool {
            return $tag->name === $name;
        });
        $tags = \array_values($tags);
        return \array_values($tags);
    }
    public function getParamType(string $name) : \PHPStan\Type\Type
    {
        $paramTagValueNodes = $this->getParamTagValueByName($name);
        return $this->getTypeOrMixed($paramTagValueNodes);
    }
    /**
     * @return ParamTagValueNode[]
     */
    public function getParamTagValueNodes() : array
    {
        return $this->phpDocNode->getParamTagValues();
    }
    public function getParamTagValueNodeByName(string $parameterName) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode
    {
        foreach ($this->phpDocNode->getParamTagValues() as $paramTagValueNode) {
            if ($paramTagValueNode->parameterName !== '$' . $parameterName) {
                continue;
            }
            return $paramTagValueNode;
        }
        return null;
    }
    public function getVarType() : \PHPStan\Type\Type
    {
        return $this->getTypeOrMixed($this->getVarTagValueNode());
    }
    public function getReturnType() : \PHPStan\Type\Type
    {
        return $this->getTypeOrMixed($this->getReturnTagValue());
    }
    /**
     * @param class-string<TNode> $type
     */
    public function hasByType(string $type) : bool
    {
        return (bool) $this->getByType($type);
    }
    /**
     * @param class-string<TNode>[] $types
     */
    public function hasByTypes(array $types) : bool
    {
        foreach ($types as $type) {
            if ($this->hasByType($type)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param string[] $names
     */
    public function hasByNames(array $names) : bool
    {
        foreach ($names as $name) {
            if ($this->hasByName($name)) {
                return \true;
            }
        }
        return \false;
    }
    public function hasByName(string $name) : bool
    {
        return (bool) $this->getTagsByName($name);
    }
    /**
     * @param class-string<TNode> $type
     * @return TNode|null
     */
    public function getByType(string $type)
    {
        $this->ensureTypeIsTagValueNode($type, __METHOD__);
        foreach ($this->phpDocNode->children as $phpDocChildNode) {
            if (\is_a($phpDocChildNode, $type, \true)) {
                return $phpDocChildNode;
            }
            if (!$phpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            if (!\is_a($phpDocChildNode->value, $type, \true)) {
                continue;
            }
            return $phpDocChildNode->value;
        }
        return null;
    }
    /**
     * @template T of \PHPStan\PhpDocParser\Ast\Node
     * @param class-string<T> $type
     * @return array<T>
     */
    public function findAllByType(string $type) : array
    {
        $this->ensureTypeIsTagValueNode($type, __METHOD__);
        $foundTagsValueNodes = [];
        foreach ($this->phpDocNode->children as $phpDocChildNode) {
            if (\is_a($phpDocChildNode, $type, \true)) {
                $foundTagsValueNodes[] = $phpDocChildNode;
                continue;
            }
            if (!$phpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            if ($type === \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode::class) {
                $foundTagsValueNodes[] = $phpDocChildNode;
                continue;
            }
            if (!\is_a($phpDocChildNode->value, $type, \true)) {
                continue;
            }
            $foundTagsValueNodes[] = $phpDocChildNode->value;
        }
        /** @var Node[] $foundTagsValueNodes */
        return $foundTagsValueNodes;
    }
    /**
     * @template T of \PHPStan\PhpDocParser\Ast\Node
     * @param class-string<T> $type
     */
    public function removeByType(string $type) : void
    {
        $this->ensureTypeIsTagValueNode($type, __METHOD__);
        foreach ($this->phpDocNode->children as $key => $phpDocChildNode) {
            if (\is_a($phpDocChildNode, $type, \true)) {
                unset($this->phpDocNode->children[$key]);
                $this->markAsChanged();
            }
            if (!$phpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            if (!\is_a($phpDocChildNode->value, $type, \true)) {
                continue;
            }
            unset($this->phpDocNode->children[$key]);
            $this->markAsChanged();
        }
    }
    /**
     * @return array<string, Type>
     */
    public function getParamTypesByName() : array
    {
        $paramTypesByName = [];
        foreach ($this->phpDocNode->getParamTagValues() as $paramTagValueNode) {
            $parameterName = $paramTagValueNode->parameterName;
            $paramTypesByName[$parameterName] = $this->staticTypeMapper->mapPHPStanPhpDocTypeToPHPStanType($paramTagValueNode, $this->node);
        }
        return $paramTypesByName;
    }
    public function addTagValueNode(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : void
    {
        if ($phpDocTagValueNode instanceof \Rector\BetterPhpDocParser\Contract\PhpDocNode\ClassNameAwareTagInterface) {
            $spacelessPhpDocTagNode = new \Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode('@\\' . $phpDocTagValueNode->getClassName(), $phpDocTagValueNode);
            $this->addPhpDocTagNode($spacelessPhpDocTagNode);
            return;
        }
        $name = $this->resolveNameForPhpDocTagValueNode($phpDocTagValueNode);
        $phpDocTagNode = new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode($name, $phpDocTagValueNode);
        $this->addPhpDocTagNode($phpDocTagNode);
    }
    public function isNewNode() : bool
    {
        if ($this->phpDocNode->children === []) {
            return \false;
        }
        return $this->tokens === [];
    }
    public function makeSingleLined() : void
    {
        $this->isSingleLine = \true;
    }
    public function isSingleLine() : bool
    {
        return $this->isSingleLine;
    }
    public function getReturnTagValue() : ?\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode
    {
        $returnTagValueNodes = $this->phpDocNode->getReturnTagValues();
        return $returnTagValueNodes[0] ?? null;
    }
    public function getParamTagValueByName(string $name) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode
    {
        $desiredParamNameWithDollar = '$' . \ltrim($name, '$');
        foreach ($this->getParamTagValueNodes() as $paramTagValueNode) {
            if ($paramTagValueNode->parameterName !== $desiredParamNameWithDollar) {
                continue;
            }
            return $paramTagValueNode;
        }
        return null;
    }
    /**
     * @return TemplateTagValueNode[]
     */
    public function getTemplateTagValueNodes() : array
    {
        return $this->phpDocNode->getTemplateTagValues();
    }
    public function hasInheritDoc() : bool
    {
        return $this->hasByNames(['inheritdoc', 'inheritDoc']);
    }
    public function markAsChanged() : void
    {
        $this->hasChanged = \true;
        $node = $this->currentNodeProvider->getNode();
        if ($node !== null) {
            $this->rectorChangeCollector->notifyNodeFileInfo($node);
        }
    }
    public function hasChanged() : bool
    {
        if ($this->isNewNode()) {
            return \true;
        }
        return $this->hasChanged;
    }
    /**
     * @return string[]
     */
    public function getMethodTagNames() : array
    {
        $methodTagNames = [];
        foreach ($this->phpDocNode->getMethodTagValues() as $methodTagValueNode) {
            $methodTagNames[] = $methodTagValueNode->methodName;
        }
        return $methodTagNames;
    }
    private function getTypeOrMixed(?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : \PHPStan\Type\Type
    {
        if ($phpDocTagValueNode === null) {
            return new \PHPStan\Type\MixedType();
        }
        return $this->staticTypeMapper->mapPHPStanPhpDocTypeToPHPStanType($phpDocTagValueNode, $this->node);
    }
    private function ensureTypeIsTagValueNode(string $type, string $location) : void
    {
        /** @var array<class-string> $desiredTypes */
        $desiredTypes = \array_merge([\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode::class, \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode::class], \Rector\BetterPhpDocParser\ValueObject\NodeTypes::TYPE_AWARE_NODES);
        if (\Rector\Core\Util\StaticInstanceOf::isOneOf($type, $desiredTypes)) {
            return;
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('Type "%s" passed to "%s()" method must be child of "%s"', $type, $location, \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode::class));
    }
    private function resolveNameForPhpDocTagValueNode(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : string
    {
        foreach (self::TAGS_TYPES_TO_NAMES as $tagValueNodeType => $name) {
            if ($phpDocTagValueNode instanceof $tagValueNodeType) {
                return $name;
            }
        }
        throw new \Rector\Core\Exception\NotImplementedYetException(\get_class($phpDocTagValueNode));
    }
}
