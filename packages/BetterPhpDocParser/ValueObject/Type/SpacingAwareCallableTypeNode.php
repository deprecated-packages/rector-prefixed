<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObject\Type;

use RectorPrefix20210402\Nette\Utils\Strings;
use PHPStan\PhpDocParser\Ast\NodeAttributes;
use PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
final class SpacingAwareCallableTypeNode extends \PHPStan\PhpDocParser\Ast\Type\CallableTypeNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        // keep original (Psalm?) format, see https://github.com/rectorphp/rector/issues/2841
        return $this->createExplicitCallable();
    }
    private function createExplicitCallable() : string
    {
        /** @var IdentifierTypeNode|GenericTypeNode $returnType */
        $returnType = $this->returnType;
        $parameterTypeString = $this->createParameterTypeString();
        $returnTypeAsString = (string) $returnType;
        if (\RectorPrefix20210402\Nette\Utils\Strings::contains($returnTypeAsString, '|')) {
            $returnTypeAsString = '(' . $returnTypeAsString . ')';
        }
        $parameterTypeString = $this->normalizeParameterType($parameterTypeString, $returnTypeAsString);
        $returnTypeAsString = $this->normalizeReturnType($parameterTypeString, $returnTypeAsString);
        return \sprintf('%s%s%s', $this->identifier->name, $parameterTypeString, $returnTypeAsString);
    }
    private function createParameterTypeString() : string
    {
        $parameterTypeStrings = [];
        foreach ($this->parameters as $parameter) {
            $parameterTypeStrings[] = \trim((string) $parameter);
        }
        $parameterTypeString = \implode(', ', $parameterTypeStrings);
        return \trim($parameterTypeString);
    }
    private function normalizeParameterType(string $parameterTypeString, string $returnTypeAsString) : string
    {
        if ($parameterTypeString !== '') {
            return '(' . $parameterTypeString . ')';
        }
        if ($returnTypeAsString === 'mixed') {
            return $parameterTypeString;
        }
        if ($returnTypeAsString === '') {
            return $parameterTypeString;
        }
        return '()';
    }
    private function normalizeReturnType(string $parameterTypeString, string $returnTypeAsString) : string
    {
        if ($returnTypeAsString !== 'mixed') {
            return ':' . $returnTypeAsString;
        }
        if ($parameterTypeString !== '') {
            return ':' . $returnTypeAsString;
        }
        return '';
    }
}
