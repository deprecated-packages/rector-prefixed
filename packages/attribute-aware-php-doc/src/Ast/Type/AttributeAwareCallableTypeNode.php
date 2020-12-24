<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\AttributeAwarePhpDoc\Ast\Type;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareCallableTypeNode extends \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode implements \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
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
        if (\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($returnTypeAsString, '|')) {
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
        if ($returnTypeAsString !== 'mixed' && $returnTypeAsString !== '') {
            return '()';
        }
        return $parameterTypeString;
    }
    private function normalizeReturnType(string $parameterTypeString, string $returnTypeAsString) : string
    {
        if ($returnTypeAsString === 'mixed' && $parameterTypeString === '') {
            return '';
        }
        return ':' . $returnTypeAsString;
    }
}
