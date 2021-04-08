<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Rector\MethodCall;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://symfony.com/doc/current/components/translation/usage.html#message-placeholders
 * @see https://github.com/Kdyby/Translation/blob/master/docs/en/index.md#placeholders
 * https://github.com/Kdyby/Translation/blob/6b0721c767a7be7f15b2fb13c529bea8536230aa/src/Translator.php#L172
 * @see \Rector\Tests\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector\WrapTransParameterNameRectorTest
 */
final class WrapTransParameterNameRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/b8boED/1
     */
    private const BETWEEN_PERCENT_CHARS_REGEX = '#%(.*?)%#';
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds %% to placeholder name of trans() method if missing', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, new \PHPStan\Type\ObjectType('Symfony\\Component\\Translation\\TranslatorInterface'))) {
            return null;
        }
        if (!$this->isName($node->name, 'trans')) {
            return null;
        }
        if (\count($node->args) < 2) {
            return null;
        }
        if (!$node->args[1]->value instanceof \PhpParser\Node\Expr\Array_) {
            return null;
        }
        /** @var Array_ $parametersArrayNode */
        $parametersArrayNode = $node->args[1]->value;
        foreach ($parametersArrayNode->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            if (!$arrayItem->key instanceof \PhpParser\Node\Scalar\String_) {
                continue;
            }
            if (\RectorPrefix20210408\Nette\Utils\Strings::match($arrayItem->key->value, self::BETWEEN_PERCENT_CHARS_REGEX)) {
                continue;
            }
            $arrayItem->key = new \PhpParser\Node\Scalar\String_('%' . $arrayItem->key->value . '%');
        }
        return $node;
    }
}
