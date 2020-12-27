<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
class CallableTypeHelper
{
    public static function isParametersAcceptorSuperTypeOf(\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor $ours, \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor $theirs, bool $treatMixedAsAny) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $theirParameters = $theirs->getParameters();
        $ourParameters = $ours->getParameters();
        $result = null;
        foreach ($theirParameters as $i => $theirParameter) {
            if (!isset($ourParameters[$i])) {
                if ($theirParameter->isOptional()) {
                    continue;
                }
                return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
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
