<?php

declare (strict_types=1);
namespace RectorPrefix20210301\Symplify\PhpConfigPrinter\NodeFactory;

use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use RectorPrefix20210301\Symfony\Component\Yaml\Tag\TaggedValue;
use RectorPrefix20210301\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
use RectorPrefix20210301\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver;
use RectorPrefix20210301\Symplify\PhpConfigPrinter\ExprResolver\TaggedReturnsCloneResolver;
use RectorPrefix20210301\Symplify\PhpConfigPrinter\ExprResolver\TaggedServiceResolver;
final class ArgsNodeFactory
{
    /**
     * @var string
     */
    private const TAG_SERVICE = 'service';
    /**
     * @var string
     */
    private const TAG_RETURNS_CLONE = 'returns_clone';
    /**
     * @var StringExprResolver
     */
    private $stringExprResolver;
    /**
     * @var TaggedReturnsCloneResolver
     */
    private $taggedReturnsCloneResolver;
    /**
     * @var TaggedServiceResolver
     */
    private $taggedServiceResolver;
    public function __construct(\RectorPrefix20210301\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver $stringExprResolver, \RectorPrefix20210301\Symplify\PhpConfigPrinter\ExprResolver\TaggedReturnsCloneResolver $taggedReturnsCloneResolver, \RectorPrefix20210301\Symplify\PhpConfigPrinter\ExprResolver\TaggedServiceResolver $taggedServiceResolver)
    {
        $this->stringExprResolver = $stringExprResolver;
        $this->taggedReturnsCloneResolver = $taggedReturnsCloneResolver;
        $this->taggedServiceResolver = $taggedServiceResolver;
    }
    /**
     * @return Arg[]
     */
    public function createFromValuesAndWrapInArray($values) : array
    {
        if (\is_array($values)) {
            $array = $this->resolveExprFromArray($values);
        } else {
            $expr = $this->resolveExpr($values);
            $items = [new \PhpParser\Node\Expr\ArrayItem($expr)];
            $array = new \PhpParser\Node\Expr\Array_($items);
        }
        return [new \PhpParser\Node\Arg($array)];
    }
    /**
     * @return Arg[]
     */
    public function createFromValues($values, bool $skipServiceReference = \false, bool $skipClassesToConstantReference = \false) : array
    {
        if (\is_array($values)) {
            $args = [];
            foreach ($values as $value) {
                $expr = $this->resolveExpr($value, $skipServiceReference, $skipClassesToConstantReference);
                $args[] = new \PhpParser\Node\Arg($expr);
            }
            return $args;
        }
        if ($values instanceof \PhpParser\Node) {
            if ($values instanceof \PhpParser\Node\Arg) {
                return [$values];
            }
            if ($values instanceof \PhpParser\Node\Expr) {
                return [new \PhpParser\Node\Arg($values)];
            }
        }
        if (\is_string($values)) {
            $expr = $this->resolveExpr($values);
            return [new \PhpParser\Node\Arg($expr)];
        }
        throw new \RectorPrefix20210301\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    public function resolveExpr($value, bool $skipServiceReference = \false, bool $skipClassesToConstantReference = \false) : \PhpParser\Node\Expr
    {
        if (\is_string($value)) {
            return $this->stringExprResolver->resolve($value, $skipServiceReference, $skipClassesToConstantReference);
        }
        if ($value instanceof \PhpParser\Node\Expr) {
            return $value;
        }
        if ($value instanceof \RectorPrefix20210301\Symfony\Component\Yaml\Tag\TaggedValue) {
            return $this->createServiceReferenceFromTaggedValue($value);
        }
        if (\is_array($value)) {
            $arrayItems = $this->resolveArrayItems($value, $skipClassesToConstantReference);
            return new \PhpParser\Node\Expr\Array_($arrayItems);
        }
        return \PhpParser\BuilderHelpers::normalizeValue($value);
    }
    private function resolveExprFromArray(array $values) : \PhpParser\Node\Expr\Array_
    {
        $arrayItems = [];
        foreach ($values as $key => $value) {
            $expr = \is_array($value) ? $this->resolveExprFromArray($value) : $this->resolveExpr($value);
            if (!\is_int($key)) {
                $keyExpr = $this->resolveExpr($key);
                $arrayItem = new \PhpParser\Node\Expr\ArrayItem($expr, $keyExpr);
            } else {
                $arrayItem = new \PhpParser\Node\Expr\ArrayItem($expr);
            }
            $arrayItems[] = $arrayItem;
        }
        return new \PhpParser\Node\Expr\Array_($arrayItems);
    }
    private function createServiceReferenceFromTaggedValue(\RectorPrefix20210301\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \PhpParser\Node\Expr
    {
        // that's the only value
        if ($taggedValue->getTag() === self::TAG_RETURNS_CLONE) {
            return $this->taggedReturnsCloneResolver->resolve($taggedValue);
        }
        if ($taggedValue->getTag() === self::TAG_SERVICE) {
            return $this->taggedServiceResolver->resolve($taggedValue);
        }
        $args = $this->createFromValues($taggedValue->getValue());
        return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name($taggedValue->getTag()), $args);
    }
    /**
     * @param mixed[] $value
     * @return ArrayItem[]
     */
    private function resolveArrayItems(array $value, bool $skipClassesToConstantReference) : array
    {
        $arrayItems = [];
        $naturalKey = 0;
        foreach ($value as $nestedKey => $nestedValue) {
            $valueExpr = $this->resolveExpr($nestedValue, \false, $skipClassesToConstantReference);
            if (!\is_int($nestedKey) || $nestedKey !== $naturalKey) {
                $keyExpr = $this->resolveExpr($nestedKey, \false, $skipClassesToConstantReference);
                $arrayItem = new \PhpParser\Node\Expr\ArrayItem($valueExpr, $keyExpr);
            } else {
                $arrayItem = new \PhpParser\Node\Expr\ArrayItem($valueExpr);
            }
            $arrayItems[] = $arrayItem;
            ++$naturalKey;
        }
        return $arrayItems;
    }
}
