<?php

declare (strict_types=1);
namespace RectorPrefix20210105\Symplify\PhpConfigPrinter\NodeFactory;

use RectorPrefix20210105\Nette\Utils\Strings;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use RectorPrefix20210105\Symfony\Component\Yaml\Tag\TaggedValue;
use RectorPrefix20210105\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use RectorPrefix20210105\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
use RectorPrefix20210105\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
use RectorPrefix20210105\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature;
final class ArgsNodeFactory
{
    /**
     * @see https://regex101.com/r/laf2wR/1
     * @var string
     */
    private const TWIG_HTML_XML_SUFFIX_REGEX = '#\\.(twig|html|xml)$#';
    /**
     * @var string
     */
    private const TAG_SERVICE = 'service';
    /**
     * @var string
     */
    private const TAG_RETURNS_CLONE = 'returns_clone';
    /**
     * @var string
     */
    private const KIND = 'kind';
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var ConstantNodeFactory
     */
    private $constantNodeFactory;
    /**
     * @var SymfonyVersionFeatureGuardInterface
     */
    private $symfonyVersionFeatureGuard;
    public function __construct(\RectorPrefix20210105\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \RectorPrefix20210105\Symplify\PhpConfigPrinter\NodeFactory\ConstantNodeFactory $constantNodeFactory, \RectorPrefix20210105\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface $symfonyVersionFeatureGuard)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->constantNodeFactory = $constantNodeFactory;
        $this->symfonyVersionFeatureGuard = $symfonyVersionFeatureGuard;
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
        throw new \RectorPrefix20210105\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    public function resolveExpr($value, bool $skipServiceReference = \false, bool $skipClassesToConstantReference = \false) : \PhpParser\Node\Expr
    {
        if (\is_string($value)) {
            return $this->resolveStringExpr($value, $skipServiceReference, $skipClassesToConstantReference);
        }
        if ($value instanceof \PhpParser\Node\Expr) {
            return $value;
        }
        if ($value instanceof \RectorPrefix20210105\Symfony\Component\Yaml\Tag\TaggedValue) {
            return $this->createServiceReferenceFromTaggedValue($value);
        }
        if (\is_array($value)) {
            $arrayItems = $this->resolveArrayItems($value, $skipClassesToConstantReference);
            return new \PhpParser\Node\Expr\Array_($arrayItems);
        }
        return \PhpParser\BuilderHelpers::normalizeValue($value);
    }
    private function resolveServiceReferenceExpr(string $value, bool $skipServiceReference, string $functionName) : \PhpParser\Node\Expr
    {
        $value = \ltrim($value, '@');
        $expr = $this->resolveExpr($value);
        if ($skipServiceReference) {
            return $expr;
        }
        $args = [new \PhpParser\Node\Arg($expr)];
        return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name\FullyQualified($functionName), $args);
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
    private function createServiceReferenceFromTaggedValue(\RectorPrefix20210105\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \PhpParser\Node\Expr
    {
        $shouldWrapInArray = \false;
        // that's the only value
        if ($taggedValue->getTag() === self::TAG_RETURNS_CLONE) {
            $serviceName = $taggedValue->getValue()[0];
            $functionName = $this->getRefOrServiceFunctionName();
            $shouldWrapInArray = \true;
        } elseif ($taggedValue->getTag() === self::TAG_SERVICE) {
            $serviceName = $taggedValue->getValue()['class'];
            $functionName = \RectorPrefix20210105\Symplify\PhpConfigPrinter\ValueObject\FunctionName::INLINE_SERVICE;
        } else {
            if (\is_array($taggedValue->getValue())) {
                $args = $this->createFromValues($taggedValue->getValue());
            } else {
                $args = $this->createFromValues([$taggedValue->getValue()]);
            }
            return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name($taggedValue->getTag()), $args);
        }
        $funcCall = $this->resolveServiceReferenceExpr($serviceName, \false, $functionName);
        if ($shouldWrapInArray) {
            return new \PhpParser\Node\Expr\Array_([new \PhpParser\Node\Expr\ArrayItem($funcCall)]);
        }
        return $funcCall;
    }
    private function resolveStringExpr(string $value, bool $skipServiceReference, bool $skipClassesToConstantReference) : \PhpParser\Node\Expr
    {
        if ($value === '') {
            return new \PhpParser\Node\Scalar\String_($value);
        }
        $constFetch = $this->constantNodeFactory->createConstantIfValue($value);
        if ($constFetch !== null) {
            return $constFetch;
        }
        // do not print "\n" as empty space, but use string value instead
        if (\in_array($value, ["\r", "\n", "\r\n"], \true)) {
            $string = new \PhpParser\Node\Scalar\String_($value);
            $string->setAttribute(self::KIND, \PhpParser\Node\Scalar\String_::KIND_DOUBLE_QUOTED);
            return $string;
        }
        $value = \ltrim($value, '\\');
        if (\ctype_upper($value[0]) && \class_exists($value) || \interface_exists($value)) {
            return $this->resolveClassType($skipClassesToConstantReference, $value);
        }
        if (\RectorPrefix20210105\Nette\Utils\Strings::startsWith($value, '@=')) {
            $value = \ltrim($value, '@=');
            $args = $this->createFromValues($value);
            return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name\FullyQualified(\RectorPrefix20210105\Symplify\PhpConfigPrinter\ValueObject\FunctionName::EXPR), $args);
        }
        // is service reference
        if (\RectorPrefix20210105\Nette\Utils\Strings::startsWith($value, '@') && !$this->isFilePath($value)) {
            $refOrServiceFunctionName = $this->getRefOrServiceFunctionName();
            return $this->resolveServiceReferenceExpr($value, $skipServiceReference, $refOrServiceFunctionName);
        }
        return \PhpParser\BuilderHelpers::normalizeValue($value);
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
    private function getRefOrServiceFunctionName() : string
    {
        if ($this->symfonyVersionFeatureGuard->isAtLeastSymfonyVersion(\RectorPrefix20210105\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature::REF_OVER_SERVICE)) {
            return \RectorPrefix20210105\Symplify\PhpConfigPrinter\ValueObject\FunctionName::SERVICE;
        }
        return \RectorPrefix20210105\Symplify\PhpConfigPrinter\ValueObject\FunctionName::REF;
    }
    private function isFilePath(string $value) : bool
    {
        return (bool) \RectorPrefix20210105\Nette\Utils\Strings::match($value, self::TWIG_HTML_XML_SUFFIX_REGEX);
    }
    private function resolveClassType(bool $skipClassesToConstantReference, string $value)
    {
        if ($skipClassesToConstantReference) {
            return new \PhpParser\Node\Scalar\String_($value);
        }
        return $this->commonNodeFactory->createClassReference($value);
    }
}
