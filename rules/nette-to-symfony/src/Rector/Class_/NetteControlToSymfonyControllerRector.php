<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteToSymfony\Rector\Class_;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\Nette\NodeFactory\ActionRenderFactory;
use _PhpScoperb75b35f52b74\Rector\Nette\TemplatePropertyAssignCollector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpFoundation\Response;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://doc.nette.org/en/2.4/components
 * ↓
 * @see https://symfony.com/doc/current/controller.html
 * @see \Rector\NetteToSymfony\Tests\Rector\Class_\NetteControlToSymfonyControllerRector\NetteControlToSymfonyControllerRectorTest
 */
final class NetteControlToSymfonyControllerRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var TemplatePropertyAssignCollector
     */
    private $templatePropertyAssignCollector;
    /**
     * @var ActionRenderFactory
     */
    private $actionRenderFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Nette\NodeFactory\ActionRenderFactory $actionRenderFactory, \_PhpScoperb75b35f52b74\Rector\Nette\TemplatePropertyAssignCollector $templatePropertyAssignCollector)
    {
        $this->templatePropertyAssignCollector = $templatePropertyAssignCollector;
        $this->actionRenderFactory = $actionRenderFactory;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Migrate Nette Component to Symfony Controller', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Application\UI\Control;

class SomeControl extends Control
{
    public function render()
    {
        $this->template->param = 'some value';
        $this->template->render(__DIR__ . '/poll.latte');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SomeController extends AbstractController
{
     public function some(): Response
     {
         return $this->render(__DIR__ . '/poll.latte', ['param' => 'some value']);
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->shouldSkipClass($node)) {
            return null;
        }
        $shortClassName = $this->getShortName($node);
        $shortClassName = $this->removeSuffix($shortClassName, 'Control');
        $shortClassName .= 'Controller';
        $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($shortClassName);
        $node->extends = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified(\_PhpScoperb75b35f52b74\Symfony\Bundle\FrameworkBundle\Controller\AbstractController::class);
        $classMethod = $node->getMethod('render');
        if ($classMethod !== null) {
            $this->processRenderMethod($classMethod);
        }
        return $node;
    }
    private function shouldSkipClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($this->isAnonymousClass($class)) {
            return \true;
        }
        // skip presenter
        if ($this->isName($class, '*Presenter')) {
            return \true;
        }
        return !$this->isObjectType($class, '_PhpScoperb75b35f52b74\\Nette\\Application\\UI\\Control');
    }
    private function removeSuffix(string $content, string $suffix) : string
    {
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($content, $suffix)) {
            return $content;
        }
        return \_PhpScoperb75b35f52b74\Nette\Utils\Strings::substring($content, 0, -\_PhpScoperb75b35f52b74\Nette\Utils\Strings::length($suffix));
    }
    private function processRenderMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->processGetPresenterGetSessionMethodCall($classMethod);
        $classMethod->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('action');
        $magicTemplatePropertyCalls = $this->templatePropertyAssignCollector->collectTemplateFileNameVariablesAndNodesToRemove($classMethod);
        $methodCall = $this->actionRenderFactory->createThisRenderMethodCall($magicTemplatePropertyCalls);
        // add return in the end
        $return = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($methodCall);
        $classMethod->stmts[] = $return;
        if ($this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            $classMethod->returnType = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified(\_PhpScoperb75b35f52b74\Symfony\Component\HttpFoundation\Response::class);
        }
        $this->removeNodes($magicTemplatePropertyCalls->getNodesToRemove());
    }
    private function processGetPresenterGetSessionMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?MethodCall {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->isName($node->name, 'getSession')) {
                return null;
            }
            if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->isName($node->var->name, 'getPresenter')) {
                return null;
            }
            $node->var = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), 'session');
            $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
            }
            $this->addConstructorDependencyToClass($classLike, new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType('_PhpScoperb75b35f52b74\\Nette\\Http\\Session'), 'session');
            return $node;
        });
    }
}
