<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PHPStan\Php8StubsMap;
use _PhpScopere8e811afab72\PHPStan\PhpDoc\Tag\ParamTag;
use _PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher;
use _PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ParserNodeTypeToPHPStanType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypehintHelper;
class Php8SignatureMapProvider implements \_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\SignatureMapProvider
{
    private const DIRECTORY = __DIR__ . '/../../../vendor/phpstan/php-8-stubs';
    /** @var FunctionSignatureMapProvider */
    private $functionSignatureMapProvider;
    /** @var FileNodesFetcher */
    private $fileNodesFetcher;
    /** @var FileTypeMapper */
    private $fileTypeMapper;
    /** @var array<string, array<string, array{ClassMethod, string}>> */
    private $methodNodes = [];
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\FunctionSignatureMapProvider $functionSignatureMapProvider, \_PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher $fileNodesFetcher, \_PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper $fileTypeMapper)
    {
        $this->functionSignatureMapProvider = $functionSignatureMapProvider;
        $this->fileNodesFetcher = $fileNodesFetcher;
        $this->fileTypeMapper = $fileTypeMapper;
    }
    public function hasMethodSignature(string $className, string $methodName, int $variant = 0) : bool
    {
        $lowerClassName = \strtolower($className);
        if (!\array_key_exists($lowerClassName, \_PhpScopere8e811afab72\PHPStan\Php8StubsMap::CLASSES)) {
            return $this->functionSignatureMapProvider->hasMethodSignature($className, $methodName, $variant);
        }
        if ($variant > 0) {
            return $this->functionSignatureMapProvider->hasMethodSignature($className, $methodName, $variant);
        }
        if ($this->findMethodNode($className, $methodName) === null) {
            return $this->functionSignatureMapProvider->hasMethodSignature($className, $methodName, $variant);
        }
        return \true;
    }
    /**
     * @param string $className
     * @param string $methodName
     * @return array{ClassMethod, string}|null
     * @throws \PHPStan\ShouldNotHappenException
     */
    private function findMethodNode(string $className, string $methodName) : ?array
    {
        $lowerClassName = \strtolower($className);
        $lowerMethodName = \strtolower($methodName);
        if (isset($this->methodNodes[$lowerClassName][$lowerMethodName])) {
            return $this->methodNodes[$lowerClassName][$lowerMethodName];
        }
        $stubFile = self::DIRECTORY . '/' . \_PhpScopere8e811afab72\PHPStan\Php8StubsMap::CLASSES[$lowerClassName];
        $nodes = $this->fileNodesFetcher->fetchNodes($stubFile);
        $classes = $nodes->getClassNodes();
        if (\count($classes) !== 1) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException(\sprintf('Class %s stub not found in %s.', $className, $stubFile));
        }
        $class = $classes[$lowerClassName];
        if (\count($class) !== 1) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException(\sprintf('Class %s stub not found in %s.', $className, $stubFile));
        }
        foreach ($class[0]->getNode()->stmts as $stmt) {
            if (!$stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
                continue;
            }
            if ($stmt->name->toLowerString() === $lowerMethodName) {
                return $this->methodNodes[$lowerClassName][$lowerMethodName] = [$stmt, $stubFile];
            }
        }
        return null;
    }
    public function hasFunctionSignature(string $name, int $variant = 0) : bool
    {
        $lowerName = \strtolower($name);
        if (!\array_key_exists($lowerName, \_PhpScopere8e811afab72\PHPStan\Php8StubsMap::FUNCTIONS)) {
            return $this->functionSignatureMapProvider->hasFunctionSignature($name, $variant);
        }
        if ($variant > 0) {
            return $this->functionSignatureMapProvider->hasFunctionSignature($name, $variant);
        }
        return \true;
    }
    public function getMethodSignature(string $className, string $methodName, ?\ReflectionMethod $reflectionMethod, int $variant = 0) : \_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\FunctionSignature
    {
        $lowerClassName = \strtolower($className);
        if (!\array_key_exists($lowerClassName, \_PhpScopere8e811afab72\PHPStan\Php8StubsMap::CLASSES)) {
            return $this->functionSignatureMapProvider->getMethodSignature($className, $methodName, $reflectionMethod, $variant);
        }
        if ($variant > 0) {
            return $this->functionSignatureMapProvider->getMethodSignature($className, $methodName, $reflectionMethod, $variant);
        }
        if ($this->functionSignatureMapProvider->hasMethodSignature($className, $methodName, 1)) {
            return $this->functionSignatureMapProvider->getMethodSignature($className, $methodName, $reflectionMethod, $variant);
        }
        $methodNode = $this->findMethodNode($className, $methodName);
        if ($methodNode === null) {
            return $this->functionSignatureMapProvider->getMethodSignature($className, $methodName, $reflectionMethod, $variant);
        }
        [$methodNode, $stubFile] = $methodNode;
        $signature = $this->getSignature($methodNode, $className, $stubFile);
        if ($this->functionSignatureMapProvider->hasMethodSignature($className, $methodName)) {
            return $this->mergeSignatures($signature, $this->functionSignatureMapProvider->getMethodSignature($className, $methodName, $reflectionMethod, $variant));
        }
        return $signature;
    }
    public function getFunctionSignature(string $functionName, ?string $className, int $variant = 0) : \_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\FunctionSignature
    {
        $lowerName = \strtolower($functionName);
        if (!\array_key_exists($lowerName, \_PhpScopere8e811afab72\PHPStan\Php8StubsMap::FUNCTIONS)) {
            return $this->functionSignatureMapProvider->getFunctionSignature($functionName, $className, $variant);
        }
        if ($variant > 0) {
            return $this->functionSignatureMapProvider->getFunctionSignature($functionName, $className, $variant);
        }
        if ($this->functionSignatureMapProvider->hasFunctionSignature($functionName, 1)) {
            return $this->functionSignatureMapProvider->getFunctionSignature($functionName, $className, $variant);
        }
        $stubFile = self::DIRECTORY . '/' . \_PhpScopere8e811afab72\PHPStan\Php8StubsMap::FUNCTIONS[$lowerName];
        $nodes = $this->fileNodesFetcher->fetchNodes($stubFile);
        $functions = $nodes->getFunctionNodes();
        if (\count($functions) !== 1) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException(\sprintf('Function %s stub not found in %s.', $functionName, $stubFile));
        }
        $signature = $this->getSignature($functions[$lowerName]->getNode(), null, $stubFile);
        if ($this->functionSignatureMapProvider->hasFunctionSignature($functionName)) {
            return $this->mergeSignatures($signature, $this->functionSignatureMapProvider->getFunctionSignature($functionName, $className));
        }
        return $signature;
    }
    private function mergeSignatures(\_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\FunctionSignature $nativeSignature, \_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\FunctionSignature $functionMapSignature) : \_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\FunctionSignature
    {
        $parameters = [];
        foreach ($nativeSignature->getParameters() as $i => $nativeParameter) {
            if (!\array_key_exists($i, $functionMapSignature->getParameters())) {
                $parameters[] = $nativeParameter;
                continue;
            }
            $functionMapParameter = $functionMapSignature->getParameters()[$i];
            $nativeParameterType = $nativeParameter->getNativeType();
            $parameters[] = new \_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\ParameterSignature($nativeParameter->getName(), $nativeParameter->isOptional(), \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType($nativeParameterType, \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType($nativeParameter->getType(), $functionMapParameter->getType())), $nativeParameterType, $nativeParameter->passedByReference()->yes() ? $functionMapParameter->passedByReference() : $nativeParameter->passedByReference(), $nativeParameter->isVariadic());
        }
        $nativeReturnType = $nativeSignature->getNativeReturnType();
        if ($nativeReturnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && !$nativeReturnType->isExplicitMixed()) {
            $returnType = $functionMapSignature->getReturnType();
        } else {
            $returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType($nativeReturnType, \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType($nativeSignature->getReturnType(), $functionMapSignature->getReturnType()));
        }
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\FunctionSignature($parameters, $returnType, $nativeReturnType, $nativeSignature->isVariadic());
    }
    public function hasMethodMetadata(string $className, string $methodName) : bool
    {
        return $this->functionSignatureMapProvider->hasMethodMetadata($className, $methodName);
    }
    public function hasFunctionMetadata(string $name) : bool
    {
        return $this->functionSignatureMapProvider->hasFunctionMetadata($name);
    }
    /**
     * @param string $className
     * @param string $methodName
     * @return array{hasSideEffects: bool}
     */
    public function getMethodMetadata(string $className, string $methodName) : array
    {
        return $this->functionSignatureMapProvider->getMethodMetadata($className, $methodName);
    }
    /**
     * @param string $functionName
     * @return array{hasSideEffects: bool}
     */
    public function getFunctionMetadata(string $functionName) : array
    {
        return $this->functionSignatureMapProvider->getFunctionMetadata($functionName);
    }
    /**
     * @param ClassMethod|Function_ $function
     * @param string $stubFile
     * @return FunctionSignature
     */
    private function getSignature(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $function, ?string $className, string $stubFile) : \_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\FunctionSignature
    {
        $phpDocParameterTypes = null;
        $phpDocReturnType = null;
        if ($function->getDocComment() !== null) {
            $phpDoc = $this->fileTypeMapper->getResolvedPhpDoc($stubFile, $className, null, $function instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod ? $function->name->toString() : $function->namespacedName->toString(), $function->getDocComment()->getText());
            $phpDocParameterTypes = \array_map(static function (\_PhpScopere8e811afab72\PHPStan\PhpDoc\Tag\ParamTag $param) : Type {
                return $param->getType();
            }, $phpDoc->getParamTags());
            if ($phpDoc->getReturnTag() !== null) {
                $phpDocReturnType = $phpDoc->getReturnTag()->getType();
            }
        }
        $parameters = [];
        $variadic = \false;
        foreach ($function->getParams() as $param) {
            $name = $param->var;
            if (!$name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable || !\is_string($name->name)) {
                throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
            }
            if ($name->name === 'array') {
                $parameterType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
            } else {
                $parameterType = \_PhpScopere8e811afab72\PHPStan\Type\ParserNodeTypeToPHPStanType::resolve($param->type, null);
            }
            $parameters[] = new \_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\ParameterSignature($name->name, $param->default !== null || $param->variadic, \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType($parameterType, $phpDocParameterTypes[$name->name] ?? null), $parameterType, $param->byRef ? \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference::createCreatesNewVariable() : \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference::createNo(), $param->variadic);
            $variadic = $variadic || $param->variadic;
        }
        $returnType = \_PhpScopere8e811afab72\PHPStan\Type\ParserNodeTypeToPHPStanType::resolve($function->getReturnType(), null);
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\SignatureMap\FunctionSignature($parameters, \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType($returnType, $phpDocReturnType ?? null), $returnType, $variadic);
    }
}
