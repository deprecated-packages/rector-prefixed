<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
class MbFunctionsReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var string[] */
    private $supportedEncodings;
    /** @var int[]  */
    private $encodingPositionMap = ['mb_http_output' => 1, 'mb_regex_encoding' => 1, 'mb_internal_encoding' => 1, 'mb_encoding_aliases' => 1, 'mb_strlen' => 2, 'mb_chr' => 2, 'mb_ord' => 2];
    public function __construct()
    {
        $supportedEncodings = [];
        if (\function_exists('mb_list_encodings')) {
            foreach (\mb_list_encodings() as $encoding) {
                $aliases = \mb_encoding_aliases($encoding);
                if ($aliases === \false) {
                    throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
                }
                $supportedEncodings = \array_merge($supportedEncodings, $aliases, [$encoding]);
            }
        }
        $this->supportedEncodings = \array_map('strtoupper', $supportedEncodings);
    }
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \array_key_exists($functionReflection->getName(), $this->encodingPositionMap);
    }
    private function isSupportedEncoding(string $encoding) : bool
    {
        return \in_array(\strtoupper($encoding), $this->supportedEncodings, \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $returnType = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        $positionEncodingParam = $this->encodingPositionMap[$functionReflection->getName()];
        if (\count($functionCall->args) < $positionEncodingParam) {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::remove($returnType, new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType());
        }
        $strings = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($functionCall->args[$positionEncodingParam - 1]->value));
        $results = \array_unique(\array_map(function (\_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType $encoding) : bool {
            return $this->isSupportedEncoding($encoding->getValue());
        }, $strings));
        if ($returnType->equals(new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType()]))) {
            return \count($results) === 1 ? new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType($results[0]) : new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType();
        }
        if (\count($results) === 1) {
            return $results[0] ? \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::remove($returnType, new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false)) : new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return $returnType;
    }
}
