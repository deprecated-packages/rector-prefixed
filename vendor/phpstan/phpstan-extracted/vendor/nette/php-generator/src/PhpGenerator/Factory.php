<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Nette\PhpGenerator;

use _HumbugBox221ad6f1b81f\Nette;
use _HumbugBox221ad6f1b81f\PhpParser;
use PhpParser\Node;
use PhpParser\ParserFactory;
/**
 * Creates a representation based on reflection.
 */
final class Factory
{
    use Nette\SmartObject;
    public function fromClassReflection(\ReflectionClass $from, bool $withBodies = \false) : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType
    {
        $class = $from->isAnonymous() ? new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType() : new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType($from->getShortName(), new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\PhpNamespace($from->getNamespaceName()));
        $class->setType($from->isInterface() ? $class::TYPE_INTERFACE : ($from->isTrait() ? $class::TYPE_TRAIT : $class::TYPE_CLASS));
        $class->setFinal($from->isFinal() && $class->isClass());
        $class->setAbstract($from->isAbstract() && $class->isClass());
        $ifaces = $from->getInterfaceNames();
        foreach ($ifaces as $iface) {
            $ifaces = \array_filter($ifaces, function (string $item) use($iface) : bool {
                return !\is_subclass_of($iface, $item);
            });
        }
        $class->setImplements($ifaces);
        $class->setComment(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::unformatDocComment((string) $from->getDocComment()));
        $class->setAttributes(self::getAttributes($from));
        if ($from->getParentClass()) {
            $class->setExtends($from->getParentClass()->name);
            $class->setImplements(\array_diff($class->getImplements(), $from->getParentClass()->getInterfaceNames()));
        }
        $props = $methods = $consts = [];
        foreach ($from->getProperties() as $prop) {
            if ($prop->isDefault() && $prop->getDeclaringClass()->name === $from->name && (\PHP_VERSION_ID < 80000 || !$prop->isPromoted())) {
                $props[] = $this->fromPropertyReflection($prop);
            }
        }
        $class->setProperties($props);
        $bodies = [];
        foreach ($from->getMethods() as $method) {
            if ($method->getDeclaringClass()->name === $from->name) {
                $methods[] = $m = $this->fromMethodReflection($method);
                if ($withBodies) {
                    $srcMethod = \_HumbugBox221ad6f1b81f\Nette\Utils\Reflection::getMethodDeclaringMethod($method);
                    $srcClass = $srcMethod->getDeclaringClass()->name;
                    $b = $bodies[$srcClass] = $bodies[$srcClass] ?? $this->loadMethodBodies($srcMethod->getDeclaringClass());
                    if (isset($b[$srcMethod->name])) {
                        $m->setBody($b[$srcMethod->name]);
                    }
                }
            }
        }
        $class->setMethods($methods);
        foreach ($from->getReflectionConstants() as $const) {
            if ($const->getDeclaringClass()->name === $from->name) {
                $consts[] = $this->fromConstantReflection($const);
            }
        }
        $class->setConstants($consts);
        return $class;
    }
    public function fromMethodReflection(\ReflectionMethod $from) : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Method
    {
        $method = new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Method($from->name);
        $method->setParameters(\array_map([$this, 'fromParameterReflection'], $from->getParameters()));
        $method->setStatic($from->isStatic());
        $isInterface = $from->getDeclaringClass()->isInterface();
        $method->setVisibility($from->isPrivate() ? \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType::VISIBILITY_PRIVATE : ($from->isProtected() ? \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType::VISIBILITY_PROTECTED : ($isInterface ? null : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType::VISIBILITY_PUBLIC)));
        $method->setFinal($from->isFinal());
        $method->setAbstract($from->isAbstract() && !$isInterface);
        $method->setBody($from->isAbstract() ? null : '');
        $method->setReturnReference($from->returnsReference());
        $method->setVariadic($from->isVariadic());
        $method->setComment(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::unformatDocComment((string) $from->getDocComment()));
        $method->setAttributes(self::getAttributes($from));
        if ($from->getReturnType() instanceof \ReflectionNamedType) {
            $method->setReturnType($from->getReturnType()->getName());
            $method->setReturnNullable($from->getReturnType()->allowsNull());
        } elseif ($from->getReturnType() instanceof \_HumbugBox221ad6f1b81f\ReflectionUnionType) {
            $method->setReturnType((string) $from->getReturnType());
        }
        return $method;
    }
    /** @return GlobalFunction|Closure */
    public function fromFunctionReflection(\ReflectionFunction $from, bool $withBody = \false)
    {
        $function = $from->isClosure() ? new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Closure() : new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\GlobalFunction($from->name);
        $function->setParameters(\array_map([$this, 'fromParameterReflection'], $from->getParameters()));
        $function->setReturnReference($from->returnsReference());
        $function->setVariadic($from->isVariadic());
        if (!$from->isClosure()) {
            $function->setComment(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::unformatDocComment((string) $from->getDocComment()));
        }
        $function->setAttributes(self::getAttributes($from));
        if ($from->getReturnType() instanceof \ReflectionNamedType) {
            $function->setReturnType($from->getReturnType()->getName());
            $function->setReturnNullable($from->getReturnType()->allowsNull());
        } elseif ($from->getReturnType() instanceof \_HumbugBox221ad6f1b81f\ReflectionUnionType) {
            $function->setReturnType((string) $from->getReturnType());
        }
        $function->setBody($withBody ? $this->loadFunctionBody($from) : '');
        return $function;
    }
    /** @return Method|GlobalFunction|Closure */
    public function fromCallable(callable $from)
    {
        $ref = \_HumbugBox221ad6f1b81f\Nette\Utils\Callback::toReflection($from);
        return $ref instanceof \ReflectionMethod ? self::fromMethodReflection($ref) : self::fromFunctionReflection($ref);
    }
    public function fromParameterReflection(\ReflectionParameter $from) : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Parameter
    {
        $param = \PHP_VERSION_ID >= 80000 && $from->isPromoted() ? new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\PromotedParameter($from->name) : new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Parameter($from->name);
        $param->setReference($from->isPassedByReference());
        if ($from->getType() instanceof \ReflectionNamedType) {
            $param->setType($from->getType()->getName());
            $param->setNullable($from->getType()->allowsNull());
        } elseif ($from->getType() instanceof \_HumbugBox221ad6f1b81f\ReflectionUnionType) {
            $param->setType((string) $from->getType());
        }
        if ($from->isDefaultValueAvailable()) {
            $param->setDefaultValue($from->isDefaultValueConstant() ? new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Literal($from->getDefaultValueConstantName()) : $from->getDefaultValue());
            $param->setNullable($param->isNullable() && $param->getDefaultValue() !== null);
        }
        $param->setAttributes(self::getAttributes($from));
        return $param;
    }
    public function fromConstantReflection(\ReflectionClassConstant $from) : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Constant
    {
        $const = new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Constant($from->name);
        $const->setValue($from->getValue());
        $const->setVisibility($from->isPrivate() ? \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType::VISIBILITY_PRIVATE : ($from->isProtected() ? \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType::VISIBILITY_PROTECTED : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType::VISIBILITY_PUBLIC));
        $const->setComment(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::unformatDocComment((string) $from->getDocComment()));
        $const->setAttributes(self::getAttributes($from));
        return $const;
    }
    public function fromPropertyReflection(\ReflectionProperty $from) : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Property
    {
        $defaults = $from->getDeclaringClass()->getDefaultProperties();
        $prop = new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Property($from->name);
        $prop->setValue($defaults[$prop->getName()] ?? null);
        $prop->setStatic($from->isStatic());
        $prop->setVisibility($from->isPrivate() ? \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType::VISIBILITY_PRIVATE : ($from->isProtected() ? \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType::VISIBILITY_PROTECTED : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType::VISIBILITY_PUBLIC));
        if (\PHP_VERSION_ID >= 70400) {
            if ($from->getType() instanceof \ReflectionNamedType) {
                $prop->setType($from->getType()->getName());
                $prop->setNullable($from->getType()->allowsNull());
            } elseif ($from->getType() instanceof \_HumbugBox221ad6f1b81f\ReflectionUnionType) {
                $prop->setType((string) $from->getType());
            }
            $prop->setInitialized($from->hasType() && \array_key_exists($prop->getName(), $defaults));
        }
        $prop->setComment(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::unformatDocComment((string) $from->getDocComment()));
        $prop->setAttributes(self::getAttributes($from));
        return $prop;
    }
    private function loadMethodBodies(\ReflectionClass $from) : array
    {
        if ($from->isAnonymous()) {
            throw new \_HumbugBox221ad6f1b81f\Nette\NotSupportedException('Anonymous classes are not supported.');
        }
        [$code, $stmts] = $this->parse($from);
        $nodeFinder = new \PhpParser\NodeFinder();
        $class = $nodeFinder->findFirst($stmts, function (\PhpParser\Node $node) use($from) {
            return ($node instanceof \PhpParser\Node\Stmt\Class_ || $node instanceof \PhpParser\Node\Stmt\Trait_) && $node->namespacedName->toString() === $from->name;
        });
        $bodies = [];
        foreach ($nodeFinder->findInstanceOf($class, \PhpParser\Node\Stmt\ClassMethod::class) as $method) {
            /** @var Node\Stmt\ClassMethod $method */
            if ($method->stmts) {
                $body = $this->extractBody($nodeFinder, $code, $method->stmts);
                $bodies[$method->name->toString()] = \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::unindent($body, 2);
            }
        }
        return $bodies;
    }
    private function loadFunctionBody(\ReflectionFunction $from) : string
    {
        if ($from->isClosure()) {
            throw new \_HumbugBox221ad6f1b81f\Nette\NotSupportedException('Closures are not supported.');
        }
        [$code, $stmts] = $this->parse($from);
        $nodeFinder = new \PhpParser\NodeFinder();
        /** @var Node\Stmt\Function_ $function */
        $function = $nodeFinder->findFirst($stmts, function (\PhpParser\Node $node) use($from) {
            return $node instanceof \PhpParser\Node\Stmt\Function_ && $node->namespacedName->toString() === $from->name;
        });
        $body = $this->extractBody($nodeFinder, $code, $function->stmts);
        return \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::unindent($body, 1);
    }
    /**
     * @param  Node[]  $statements
     */
    private function extractBody(\PhpParser\NodeFinder $nodeFinder, string $originalCode, array $statements) : string
    {
        $start = $statements[0]->getAttribute('startFilePos');
        $body = \substr($originalCode, $start, \end($statements)->getAttribute('endFilePos') - $start + 1);
        $replacements = [];
        // name-nodes => resolved fully-qualified name
        foreach ($nodeFinder->findInstanceOf($statements, \PhpParser\Node\Name::class) as $node) {
            if ($node->hasAttribute('resolvedName') && $node->getAttribute('resolvedName') instanceof \PhpParser\Node\Name\FullyQualified) {
                $replacements[] = [$node->getStartFilePos(), $node->getEndFilePos(), $node->getAttribute('resolvedName')->toCodeString()];
            }
        }
        // multi-line strings => singleline
        foreach (\array_merge($nodeFinder->findInstanceOf($statements, \PhpParser\Node\Scalar\String_::class), $nodeFinder->findInstanceOf($statements, \PhpParser\Node\Scalar\EncapsedStringPart::class)) as $node) {
            $token = \substr($body, $node->getStartFilePos() - $start, $node->getEndFilePos() - $node->getStartFilePos() + 1);
            if (\strpos($token, "\n") !== \false) {
                $quote = $node instanceof \PhpParser\Node\Scalar\String_ ? '"' : '';
                $replacements[] = [$node->getStartFilePos(), $node->getEndFilePos(), $quote . \addcslashes($node->value, "\0..\37") . $quote];
            }
        }
        // HEREDOC => "string"
        foreach ($nodeFinder->findInstanceOf($statements, \PhpParser\Node\Scalar\Encapsed::class) as $node) {
            if ($node->getAttribute('kind') === \PhpParser\Node\Scalar\String_::KIND_HEREDOC) {
                $replacements[] = [$node->getStartFilePos(), $node->parts[0]->getStartFilePos() - 1, '"'];
                $replacements[] = [\end($node->parts)->getEndFilePos() + 1, $node->getEndFilePos(), '"'];
            }
        }
        //sort collected resolved names by position in file
        \usort($replacements, function ($a, $b) {
            return $a[0] <=> $b[0];
        });
        $correctiveOffset = -$start;
        //replace changes body length so we need correct offset
        foreach ($replacements as [$startPos, $endPos, $replacement]) {
            $replacingStringLength = $endPos - $startPos + 1;
            $body = \substr_replace($body, $replacement, $correctiveOffset + $startPos, $replacingStringLength);
            $correctiveOffset += \strlen($replacement) - $replacingStringLength;
        }
        return $body;
    }
    private function parse($from) : array
    {
        $file = $from->getFileName();
        if (!\class_exists(\PhpParser\ParserFactory::class)) {
            throw new \_HumbugBox221ad6f1b81f\Nette\NotSupportedException("PHP-Parser is required to load method bodies, install package 'nikic/php-parser'.");
        } elseif (!$file) {
            throw new \_HumbugBox221ad6f1b81f\Nette\InvalidStateException("Source code of {$from->name} not found.");
        }
        $lexer = new \PhpParser\Lexer(['usedAttributes' => ['startFilePos', 'endFilePos']]);
        $parser = (new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::ONLY_PHP7, $lexer);
        $code = \file_get_contents($file);
        $code = \str_replace("\r\n", "\n", $code);
        $stmts = $parser->parse($code);
        $traverser = new \PhpParser\NodeTraverser();
        $traverser->addVisitor(new \PhpParser\NodeVisitor\NameResolver(null, ['replaceNodes' => \false]));
        $stmts = $traverser->traverse($stmts);
        return [$code, $stmts];
    }
    private function getAttributes($from) : array
    {
        if (\PHP_VERSION_ID < 80000) {
            return [];
        }
        $res = [];
        foreach ($from->getAttributes() as $attr) {
            $res[] = new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Attribute($attr->getName(), $attr->getArguments());
        }
        return $res;
    }
}
