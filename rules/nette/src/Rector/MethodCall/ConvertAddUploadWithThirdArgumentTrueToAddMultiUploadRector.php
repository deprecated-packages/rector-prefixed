<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Nette\Tests\Rector\MethodCall\ConvertAddUploadWithThirdArgumentTrueToAddMultiUploadRector\ConvertAddUploadWithThirdArgumentTrueToAddMultiUploadRectorTest
 */
final class ConvertAddUploadWithThirdArgumentTrueToAddMultiUploadRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('convert addUpload() with 3rd argument true to addMultiUpload()', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$form = new Nette\Forms\Form();
$form->addUpload('...', '...', true);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$form = new Nette\Forms\Form();
$form->addMultiUpload('...', '...');
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScoperb75b35f52b74\\Nette\\Forms\\Form')) {
            return null;
        }
        if (!$this->isName($node->name, 'addUpload')) {
            return null;
        }
        $args = $node->args;
        if (!isset($args[2])) {
            return null;
        }
        if ($this->isTrue($node->args[2]->value)) {
            $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('addMultiUpload');
            unset($node->args[2]);
            return $node;
        }
        return null;
    }
}
