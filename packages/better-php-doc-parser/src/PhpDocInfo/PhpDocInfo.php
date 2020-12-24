<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareReturnTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Annotation\StaticAnnotationNaming;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocRemover;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
/**
 * @see \Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfo\PhpDocInfoTest
 */
final class PhpDocInfo
{
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
     * @var AttributeAwarePhpDocNode
     */
    private $phpDocNode;
    /**
     * @var AttributeAwarePhpDocNode
     */
    private $originalPhpDocNode;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var Node
     */
    private $node;
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    /**
     * @var PhpDocRemover
     */
    private $phpDocRemover;
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    /**
     * @param mixed[] $tokens
     */
    public function __construct(\_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode $attributeAwarePhpDocNode, array $tokens, string $originalContent, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocRemover $phpDocRemover, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory)
    {
        $this->phpDocNode = $attributeAwarePhpDocNode;
        $this->tokens = $tokens;
        $this->originalPhpDocNode = clone $attributeAwarePhpDocNode;
        $this->originalContent = $originalContent;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->node = $node;
        $this->phpDocTypeChanger = $phpDocTypeChanger;
        $this->phpDocRemover = $phpDocRemover;
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
    }
    public function getOriginalContent() : string
    {
        return $this->originalContent;
    }
    public function addPhpDocTagNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode $phpDocChildNode) : void
    {
        $this->phpDocNode->children[] = $phpDocChildNode;
    }
    public function addTagValueNodeWithShortName(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface $shortNameAwareTag) : void
    {
        $spacelessPhpDocTagNode = new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode($shortNameAwareTag->getShortName(), $shortNameAwareTag);
        $this->addPhpDocTagNode($spacelessPhpDocTagNode);
    }
    public function getPhpDocNode() : \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode
    {
        return $this->phpDocNode;
    }
    public function getOriginalPhpDocNode() : \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocNode
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
    public function getVarTagValueNode() : ?\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode
    {
        return $this->phpDocNode->getVarTagValues()[0] ?? null;
    }
    /**
     * @return PhpDocTagNode[]|AttributeAwareNodeInterface[]
     */
    public function getTagsByName(string $name) : array
    {
        $name = \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Annotation\StaticAnnotationNaming::normalizeName($name);
        /** @var AttributeAwareNodeInterface[]|PhpDocTagNode[] $tags */
        $tags = $this->phpDocNode->getTags();
        $tags = \array_filter($tags, function (\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode $tag) use($name) : bool {
            return $tag->name === $name;
        });
        // @todo add dynamic function type resolver to PHPStan, the same type on input is on output
        $tags = \array_values($tags);
        /** @var PhpDocTagNode[]|AttributeAwareNodeInterface[] $tags */
        return $tags;
    }
    public function getParamType(string $name) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $attributeAwareParamTagValueNode = $this->getParamTagValueByName($name);
        return $this->getTypeOrMixed($attributeAwareParamTagValueNode);
    }
    /**
     * @return ParamTagValueNode[]
     */
    public function getParamTagValueNodes() : array
    {
        return $this->phpDocNode->getParamTagValues();
    }
    public function getParamTagValueNodeByName(string $parameterName) : ?\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode
    {
        foreach ($this->phpDocNode->getParamTagValues() as $paramTagValueNode) {
            if ($paramTagValueNode->parameterName !== '$' . $parameterName) {
                continue;
            }
            return $paramTagValueNode;
        }
        return null;
    }
    public function getVarType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->getTypeOrMixed($this->getVarTagValueNode());
    }
    public function getReturnType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->getTypeOrMixed($this->getReturnTagValue());
    }
    public function removeTagValueNodeFromNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : void
    {
        $this->phpDocRemover->removeTagValueFromNode($this, $phpDocTagValueNode);
    }
    public function hasByType(string $type) : bool
    {
        return (bool) $this->getByType($type);
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
    public function getByType(string $type) : ?\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        $this->ensureTypeIsTagValueNode($type, __METHOD__);
        foreach ($this->phpDocNode->children as $phpDocChildNode) {
            if (!$phpDocChildNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
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
     * @param class-string $type
     * @return PhpDocTagValueNode[]
     */
    public function findAllByType(string $type) : array
    {
        $this->ensureTypeIsTagValueNode($type, __METHOD__);
        $foundTagsValueNodes = [];
        foreach ($this->phpDocNode->children as $phpDocChildNode) {
            if (!$phpDocChildNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            if (!\is_a($phpDocChildNode->value, $type, \true)) {
                continue;
            }
            $foundTagsValueNodes[] = $phpDocChildNode->value;
        }
        return $foundTagsValueNodes;
    }
    public function removeByType(string $type) : void
    {
        $this->ensureTypeIsTagValueNode($type, __METHOD__);
        foreach ($this->phpDocNode->children as $key => $phpDocChildNode) {
            if (!$phpDocChildNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            if (!\is_a($phpDocChildNode->value, $type, \true)) {
                continue;
            }
            unset($this->phpDocNode->children[$key]);
        }
    }
    public function removeByName(string $name) : void
    {
        $this->phpDocRemover->removeByName($this, $name);
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
    public function changeVarType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : void
    {
        $this->phpDocTypeChanger->changeVarType($this, $type);
    }
    public function changeReturnType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $newType) : void
    {
        $this->phpDocTypeChanger->changeReturnType($this, $newType);
    }
    public function addBareTag(string $tag) : void
    {
        $tag = '@' . \ltrim($tag, '@');
        $attributeAwarePhpDocTagNode = new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode($tag, new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode(''));
        $this->addPhpDocTagNode($attributeAwarePhpDocTagNode);
    }
    public function addTagValueNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : void
    {
        $name = $this->resolveNameForPhpDocTagValueNode($phpDocTagValueNode);
        $attributeAwarePhpDocTagNode = new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode($name, $phpDocTagValueNode);
        $this->addPhpDocTagNode($attributeAwarePhpDocTagNode);
    }
    public function isNewNode() : bool
    {
        if ($this->phpDocNode->children === []) {
            return \false;
        }
        return $this->tokens === [];
    }
    public function changeParamType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, string $paramName) : void
    {
        $this->phpDocTypeChanger->changeParamType($this, $type, $param, $paramName);
    }
    /**
     * @return class-string[]
     */
    public function getThrowsClassNames() : array
    {
        $throwsClasses = [];
        foreach ($this->getThrowsTypes() as $throwsType) {
            if ($throwsType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
                /** @var class-string $className */
                $className = $throwsType->getFullyQualifiedName();
                $throwsClasses[] = $className;
            }
            if ($throwsType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType) {
                /** @var class-string $className */
                $className = $throwsType->getClassName();
                $throwsClasses[] = $className;
            }
        }
        return $throwsClasses;
    }
    public function makeSingleLined() : void
    {
        $this->isSingleLine = \true;
    }
    public function isSingleLine() : bool
    {
        return $this->isSingleLine;
    }
    public function getReturnTagValue() : ?\_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareReturnTagValueNode
    {
        /** @var AttributeAwareReturnTagValueNode[] $returnTagValueNodes */
        $returnTagValueNodes = $this->phpDocNode->getReturnTagValues();
        return $returnTagValueNodes[0] ?? null;
    }
    public function getParamTagValueByName(string $name) : ?\_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode
    {
        $paramTagValueNode = $this->phpDocNode->getParam($name);
        if ($paramTagValueNode === null) {
            return null;
        }
        $attributeAwareParamTagValueNode = $this->attributeAwareNodeFactory->createFromNode($paramTagValueNode, '');
        if (!$attributeAwareParamTagValueNode instanceof \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $attributeAwareParamTagValueNode;
    }
    private function getTypeOrMixed(?\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($phpDocTagValueNode === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return $this->staticTypeMapper->mapPHPStanPhpDocTypeToPHPStanType($phpDocTagValueNode, $this->node);
    }
    private function ensureTypeIsTagValueNode(string $type, string $location) : void
    {
        if (\is_a($type, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode::class, \true)) {
            return;
        }
        if (\is_a($type, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface::class, \true)) {
            return;
        }
        if (\is_a($type, \_PhpScoperb75b35f52b74\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface::class, \true)) {
            return;
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException(\sprintf('Type "%s" passed to "%s()" method must be child of "%s"', $type, $location, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode::class));
    }
    private function resolveNameForPhpDocTagValueNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : string
    {
        if ($phpDocTagValueNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode) {
            return '@return';
        }
        if ($phpDocTagValueNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode) {
            return '@param';
        }
        if ($phpDocTagValueNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode) {
            return '@var';
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException();
    }
    /**
     * @return Type[]
     */
    private function getThrowsTypes() : array
    {
        $throwsTypes = [];
        foreach ($this->phpDocNode->getThrowsTagValues() as $throwsTagValueNode) {
            $throwsTypes[] = $this->staticTypeMapper->mapPHPStanPhpDocTypeToPHPStanType($throwsTagValueNode, $this->node);
        }
        return $throwsTypes;
    }
}
