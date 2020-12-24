<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Rector\MethodCall;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://symfony.com/doc/current/components/translation/usage.html#message-placeholders
 * @see https://github.com/Kdyby/Translation/blob/master/docs/en/index.md#placeholders
 * https://github.com/Kdyby/Translation/blob/6b0721c767a7be7f15b2fb13c529bea8536230aa/src/Translator.php#L172
 * @see \Rector\NetteToSymfony\Tests\Rector\MethodCall\WrapTransParameterNameRector\WrapTransParameterNameRectorTest
 */
final class WrapTransParameterNameRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/b8boED/1
     */
    private const BETWEEN_PERCENT_CHARS_REGEX = '#%(.*?)%#';
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds %% to placeholder name of trans() method if missing', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Translation\Translator;

final class SomeController
{
    public function run()
    {
        $translator = new Translator('');
        $translated = $translator->trans(
            'Hello %name%',
            ['name' => $name]
        );
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Translation\Translator;

final class SomeController
{
    public function run()
    {
        $translator = new Translator('');
        $translated = $translator->trans(
            'Hello %name%',
            ['%name%' => $name]
        );
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScoper0a6b37af0871\\Symfony\\Component\\Translation\\TranslatorInterface')) {
            return null;
        }
        if (!$this->isName($node->name, 'trans')) {
            return null;
        }
        if (\count((array) $node->args) < 2) {
            return null;
        }
        if (!$node->args[1]->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
            return null;
        }
        /** @var Array_ $parametersArrayNode */
        $parametersArrayNode = $node->args[1]->value;
        foreach ($parametersArrayNode->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            if (!$arrayItem->key instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
                continue;
            }
            if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($arrayItem->key->value, self::BETWEEN_PERCENT_CHARS_REGEX)) {
                continue;
            }
            $arrayItem->key = new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_('%' . $arrayItem->key->value . '%');
        }
        return $node;
    }
}
