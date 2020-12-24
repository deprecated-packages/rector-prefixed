<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeStringResolver;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class SignatureMapParser
{
    /** @var \PHPStan\PhpDoc\TypeStringResolver */
    private $typeStringResolver;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeStringResolver $typeNodeResolver)
    {
        $this->typeStringResolver = $typeNodeResolver;
    }
    /**
     * @param mixed[] $map
     * @param string|null $className
     * @return \PHPStan\Reflection\SignatureMap\FunctionSignature
     */
    public function getFunctionSignature(array $map, ?string $className) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap\FunctionSignature
    {
        $parameterSignatures = $this->getParameters(\array_slice($map, 1));
        $hasVariadic = \false;
        foreach ($parameterSignatures as $parameterSignature) {
            if ($parameterSignature->isVariadic()) {
                $hasVariadic = \true;
                break;
            }
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap\FunctionSignature($parameterSignatures, $this->getTypeFromString($map[0], $className), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), $hasVariadic);
    }
    private function getTypeFromString(string $typeString, ?string $className) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($typeString === '') {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(\true);
        }
        return $this->typeStringResolver->resolve($typeString, new \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope(null, [], $className));
    }
    /**
     * @param array<string, string> $parameterMap
     * @return array<int, \PHPStan\Reflection\SignatureMap\ParameterSignature>
     */
    private function getParameters(array $parameterMap) : array
    {
        $parameterSignatures = [];
        foreach ($parameterMap as $parameterName => $typeString) {
            [$name, $isOptional, $passedByReference, $isVariadic] = $this->getParameterInfoFromName($parameterName);
            $parameterSignatures[] = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap\ParameterSignature($name, $isOptional, $this->getTypeFromString($typeString, null), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), $passedByReference, $isVariadic);
        }
        return $parameterSignatures;
    }
    /**
     * @param string $parameterNameString
     * @return mixed[]
     */
    private function getParameterInfoFromName(string $parameterNameString) : array
    {
        $matches = \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($parameterNameString, '#^(?P<reference>&(?:\\.\\.\\.)?r?w?_?)?(?P<variadic>\\.\\.\\.)?(?P<name>[^=]+)?(?P<optional>=)?($)#');
        if ($matches === null || !isset($matches['optional'])) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        $isVariadic = $matches['variadic'] !== '';
        $reference = $matches['reference'];
        if (\strpos($reference, '&...') === 0) {
            $reference = '&' . \substr($reference, 4);
            $isVariadic = \true;
        }
        if (\strpos($reference, '&rw') === 0) {
            $passedByReference = \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference::createReadsArgument();
        } elseif (\strpos($reference, '&w') === 0) {
            $passedByReference = \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference::createCreatesNewVariable();
        } else {
            $passedByReference = \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference::createNo();
        }
        $isOptional = $isVariadic || $matches['optional'] !== '';
        $name = $matches['name'] !== '' ? $matches['name'] : '...';
        return [$name, $isOptional, $passedByReference, $isVariadic];
    }
}
