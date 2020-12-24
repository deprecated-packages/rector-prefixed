<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
class MbFunctionsReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
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
                    throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
                }
                $supportedEncodings = \array_merge($supportedEncodings, $aliases, [$encoding]);
            }
        }
        $this->supportedEncodings = \array_map('strtoupper', $supportedEncodings);
    }
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \array_key_exists($functionReflection->getName(), $this->encodingPositionMap);
    }
    private function isSupportedEncoding(string $encoding) : bool
    {
        return \in_array(\strtoupper($encoding), $this->supportedEncodings, \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $returnType = \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        $positionEncodingParam = $this->encodingPositionMap[$functionReflection->getName()];
        if (\count($functionCall->args) < $positionEncodingParam) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::remove($returnType, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType());
        }
        $strings = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($functionCall->args[$positionEncodingParam - 1]->value));
        $results = \array_unique(\array_map(function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType $encoding) : bool {
            return $this->isSupportedEncoding($encoding->getValue());
        }, $strings));
        if ($returnType->equals(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType()]))) {
            return \count($results) === 1 ? new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType($results[0]) : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType();
        }
        if (\count($results) === 1) {
            return $results[0] ? \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::remove($returnType, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false)) : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return $returnType;
    }
}
