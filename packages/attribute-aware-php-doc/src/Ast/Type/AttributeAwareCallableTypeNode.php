<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareCallableTypeNode extends \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode implements \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
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
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($returnTypeAsString, '|')) {
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
