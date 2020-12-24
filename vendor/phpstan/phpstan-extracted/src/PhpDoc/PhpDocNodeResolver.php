<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\DeprecatedTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ExtendsTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ImplementsTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\MethodTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\MethodTagParameter;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\MixinTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ParamTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\PropertyTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ReturnTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\TemplateTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ThrowsTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\UsesTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\VarTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\MixinTagValueNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator;
class PhpDocNodeResolver
{
    /** @var TypeNodeResolver */
    private $typeNodeResolver;
    /** @var ConstExprNodeResolver */
    private $constExprNodeResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver, \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\ConstExprNodeResolver $constExprNodeResolver)
    {
        $this->typeNodeResolver = $typeNodeResolver;
        $this->constExprNodeResolver = $constExprNodeResolver;
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<string|int, \PHPStan\PhpDoc\Tag\VarTag>
     */
    public function resolveVarTags(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : array
    {
        foreach (['@phpstan-var', '@psalm-var', '@var'] as $tagName) {
            $resolved = [];
            foreach ($phpDocNode->getVarTagValues($tagName) as $tagValue) {
                $type = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
                if ($this->shouldSkipType($tagName, $type)) {
                    continue;
                }
                if ($tagValue->variableName !== '') {
                    $variableName = \substr($tagValue->variableName, 1);
                    $resolved[$variableName] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\VarTag($type);
                } else {
                    $resolved[] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\VarTag($type);
                }
            }
            if (\count($resolved) > 0) {
                return $resolved;
            }
        }
        return [];
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<string, \PHPStan\PhpDoc\Tag\PropertyTag>
     */
    public function resolvePropertyTags(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach ($phpDocNode->getPropertyTagValues() as $tagValue) {
            $propertyName = \substr($tagValue->propertyName, 1);
            $propertyType = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
            $resolved[$propertyName] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\PropertyTag($propertyType, \true, \true);
        }
        foreach ($phpDocNode->getPropertyReadTagValues() as $tagValue) {
            $propertyName = \substr($tagValue->propertyName, 1);
            $propertyType = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
            $resolved[$propertyName] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\PropertyTag($propertyType, \true, \false);
        }
        foreach ($phpDocNode->getPropertyWriteTagValues() as $tagValue) {
            $propertyName = \substr($tagValue->propertyName, 1);
            $propertyType = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
            $resolved[$propertyName] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\PropertyTag($propertyType, \false, \true);
        }
        return $resolved;
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<string, \PHPStan\PhpDoc\Tag\MethodTag>
     */
    public function resolveMethodTags(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach (['@method', '@psalm-method', '@phpstan-method'] as $tagName) {
            foreach ($phpDocNode->getMethodTagValues($tagName) as $tagValue) {
                $parameters = [];
                foreach ($tagValue->parameters as $parameterNode) {
                    $parameterName = \substr($parameterNode->parameterName, 1);
                    $type = $parameterNode->type !== null ? $this->typeNodeResolver->resolve($parameterNode->type, $nameScope) : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
                    if ($parameterNode->defaultValue instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode) {
                        $type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::addNull($type);
                    }
                    $defaultValue = null;
                    if ($parameterNode->defaultValue !== null) {
                        $defaultValue = $this->constExprNodeResolver->resolve($parameterNode->defaultValue);
                    }
                    $parameters[$parameterName] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\MethodTagParameter($type, $parameterNode->isReference ? \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference::createCreatesNewVariable() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference::createNo(), $parameterNode->isVariadic || $parameterNode->defaultValue !== null, $parameterNode->isVariadic, $defaultValue);
                }
                $resolved[$tagValue->methodName] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\MethodTag($tagValue->returnType !== null ? $this->typeNodeResolver->resolve($tagValue->returnType, $nameScope) : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(), $tagValue->isStatic, $parameters);
            }
        }
        return $resolved;
    }
    /**
     * @return array<string, \PHPStan\PhpDoc\Tag\ExtendsTag>
     */
    public function resolveExtendsTags(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach (['@extends', '@template-extends', '@phpstan-extends'] as $tagName) {
            foreach ($phpDocNode->getExtendsTagValues($tagName) as $tagValue) {
                $resolved[$tagValue->type->type->name] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ExtendsTag($this->typeNodeResolver->resolve($tagValue->type, $nameScope));
            }
        }
        return $resolved;
    }
    /**
     * @return array<string, \PHPStan\PhpDoc\Tag\ImplementsTag>
     */
    public function resolveImplementsTags(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach (['@implements', '@template-implements', '@phpstan-implements'] as $tagName) {
            foreach ($phpDocNode->getImplementsTagValues($tagName) as $tagValue) {
                $resolved[$tagValue->type->type->name] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ImplementsTag($this->typeNodeResolver->resolve($tagValue->type, $nameScope));
            }
        }
        return $resolved;
    }
    /**
     * @return array<string, \PHPStan\PhpDoc\Tag\UsesTag>
     */
    public function resolveUsesTags(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach (['@use', '@template-use', '@phpstan-use'] as $tagName) {
            foreach ($phpDocNode->getUsesTagValues($tagName) as $tagValue) {
                $resolved[$tagValue->type->type->name] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\UsesTag($this->typeNodeResolver->resolve($tagValue->type, $nameScope));
            }
        }
        return $resolved;
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<string, \PHPStan\PhpDoc\Tag\TemplateTag>
     */
    public function resolveTemplateTags(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        $resolvedPrefix = [];
        $prefixPriority = ['' => 0, 'psalm' => 1, 'phpstan' => 2];
        foreach ($phpDocNode->getTags() as $phpDocTagNode) {
            $valueNode = $phpDocTagNode->value;
            if (!$valueNode instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode) {
                continue;
            }
            $tagName = $phpDocTagNode->name;
            if (\in_array($tagName, ['@template', '@psalm-template', '@phpstan-template'], \true)) {
                $variance = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant();
            } elseif (\in_array($tagName, ['@template-covariant', '@psalm-template-covariant', '@phpstan-template-covariant'], \true)) {
                $variance = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant();
            } else {
                continue;
            }
            if (\strpos($tagName, '@psalm-') === 0) {
                $prefix = 'psalm';
            } elseif (\strpos($tagName, '@phpstan-') === 0) {
                $prefix = 'phpstan';
            } else {
                $prefix = '';
            }
            if (isset($resolved[$valueNode->name])) {
                $setPrefix = $resolvedPrefix[$valueNode->name];
                if ($prefixPriority[$prefix] <= $prefixPriority[$setPrefix]) {
                    continue;
                }
            }
            $resolved[$valueNode->name] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\TemplateTag($valueNode->name, $valueNode->bound !== null ? $this->typeNodeResolver->resolve($valueNode->bound, $nameScope) : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(), $variance);
            $resolvedPrefix[$valueNode->name] = $prefix;
        }
        return $resolved;
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<string, \PHPStan\PhpDoc\Tag\ParamTag>
     */
    public function resolveParamTags(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach (['@param', '@psalm-param', '@phpstan-param'] as $tagName) {
            foreach ($phpDocNode->getParamTagValues($tagName) as $tagValue) {
                $parameterName = \substr($tagValue->parameterName, 1);
                $parameterType = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
                if ($this->shouldSkipType($tagName, $parameterType)) {
                    continue;
                }
                $resolved[$parameterName] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ParamTag($parameterType, $tagValue->isVariadic);
            }
        }
        return $resolved;
    }
    public function resolveReturnTag(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ReturnTag
    {
        $resolved = null;
        foreach (['@return', '@psalm-return', '@phpstan-return'] as $tagName) {
            foreach ($phpDocNode->getReturnTagValues($tagName) as $tagValue) {
                $type = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
                if ($this->shouldSkipType($tagName, $type)) {
                    continue;
                }
                $resolved = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ReturnTag($type, \true);
            }
        }
        return $resolved;
    }
    public function resolveThrowsTags(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ThrowsTag
    {
        foreach (['@phpstan-throws', '@throws'] as $tagName) {
            $types = [];
            foreach ($phpDocNode->getThrowsTagValues($tagName) as $tagValue) {
                $type = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
                if ($this->shouldSkipType($tagName, $type)) {
                    continue;
                }
                $types[] = $type;
            }
            if (\count($types) > 0) {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\ThrowsTag(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union(...$types));
            }
        }
        return null;
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<MixinTag>
     */
    public function resolveMixinTags(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : array
    {
        return \array_map(function (\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\MixinTagValueNode $mixinTagValueNode) use($nameScope) : MixinTag {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\MixinTag($this->typeNodeResolver->resolve($mixinTagValueNode->type, $nameScope));
        }, $phpDocNode->getMixinTagValues());
    }
    public function resolveDeprecatedTag(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\DeprecatedTag
    {
        foreach ($phpDocNode->getDeprecatedTagValues() as $deprecatedTagValue) {
            $description = (string) $deprecatedTagValue;
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\DeprecatedTag($description === '' ? null : $description);
        }
        return null;
    }
    public function resolveIsDeprecated(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : bool
    {
        $deprecatedTags = $phpDocNode->getTagsByName('@deprecated');
        return \count($deprecatedTags) > 0;
    }
    public function resolveIsInternal(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : bool
    {
        $internalTags = $phpDocNode->getTagsByName('@internal');
        return \count($internalTags) > 0;
    }
    public function resolveIsFinal(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : bool
    {
        $finalTags = $phpDocNode->getTagsByName('@final');
        return \count($finalTags) > 0;
    }
    private function shouldSkipType(string $tagName, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : bool
    {
        if (\strpos($tagName, '@psalm-') !== 0) {
            return \false;
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
            return \true;
        }
        return $type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType && !$type->isExplicit();
    }
}
