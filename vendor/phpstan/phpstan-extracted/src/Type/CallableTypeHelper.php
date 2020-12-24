<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
class CallableTypeHelper
{
    public static function isParametersAcceptorSuperTypeOf(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor $ours, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor $theirs, bool $treatMixedAsAny) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        $theirParameters = $theirs->getParameters();
        $ourParameters = $ours->getParameters();
        $result = null;
        foreach ($theirParameters as $i => $theirParameter) {
            if (!isset($ourParameters[$i])) {
                if ($theirParameter->isOptional()) {
                    continue;
                }
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
            }
            $ourParameter = $ourParameters[$i];
            $ourParameterType = $ourParameter->getType();
            if ($treatMixedAsAny) {
                $isSuperType = $theirParameter->getType()->accepts($ourParameterType, \true);
            } else {
                $isSuperType = $theirParameter->getType()->isSuperTypeOf($ourParameterType);
            }
            if ($result === null) {
                $result = $isSuperType;
            } else {
                $result = $result->and($isSuperType);
            }
        }
        $theirReturnType = $theirs->getReturnType();
        if ($treatMixedAsAny) {
            $isReturnTypeSuperType = $ours->getReturnType()->accepts($theirReturnType, \true);
        } else {
            $isReturnTypeSuperType = $ours->getReturnType()->isSuperTypeOf($theirReturnType);
        }
        if ($result === null) {
            $result = $isReturnTypeSuperType;
        } else {
            $result = $result->and($isReturnTypeSuperType);
        }
        return $result;
    }
}
