<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Rector\AbstractRector;
use Rector\NetteToSymfony\Collector\OnFormVariableMethodCallsCollector;
use Rector\NetteToSymfony\NodeFactory\SymfonyControllerFactory;
use Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper88fe6e0ad041\Symfony\Component\Form\Extension\Core\Type\TextType;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see https://symfony.com/doc/current/forms.html#creating-form-classes
 *
 * @see \Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\FormControlToControllerAndFormTypeRectorTest
 */
final class FormControlToControllerAndFormTypeRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var OnFormVariableMethodCallsCollector
     */
    private $onFormVariableMethodCallsCollector;
    /**
     * @var SymfonyControllerFactory
     */
    private $symfonyControllerFactory;
    public function __construct(\Rector\NetteToSymfony\Collector\OnFormVariableMethodCallsCollector $onFormVariableMethodCallsCollector, \Rector\NetteToSymfony\NodeFactory\SymfonyControllerFactory $symfonyControllerFactory)
    {
        $this->onFormVariableMethodCallsCollector = $onFormVariableMethodCallsCollector;
        $this->symfonyControllerFactory = $symfonyControllerFactory;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Form that extends Control to Controller and decoupled FormType', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample(<<<'CODE_SAMPLE'
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;

class SomeForm extends Control
{
    public function createComponentForm()
    {
        $form = new Form();
        $form->addText('name', 'Your name');

        $form->onSuccess[] = [$this, 'processForm'];
    }

    public function processForm(Form $form)
    {
        // process me
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeFormController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route(...)
     */
    public function actionSomeForm(\Symfony\Component\HttpFoundation\Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $form = $this->createForm(SomeFormType::class);
        $form->handleRequest($request);

        if ($form->isSuccess() && $form->isValid()) {
            // process me
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
<?php

namespace _PhpScoper88fe6e0ad041;

use _PhpScoper88fe6e0ad041\Symfony\Component\Form\AbstractType;
use _PhpScoper88fe6e0ad041\Symfony\Component\Form\Extension\Core\Type\TextType;
use _PhpScoper88fe6e0ad041\Symfony\Component\Form\FormBuilderInterface;
class SomeFormType extends \_PhpScoper88fe6e0ad041\Symfony\Component\Form\AbstractType
{
    public function buildForm(\_PhpScoper88fe6e0ad041\Symfony\Component\Form\FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder->add('name', \_PhpScoper88fe6e0ad041\Symfony\Component\Form\Extension\Core\Type\TextType::class, ['label' => 'Your name']);
    }
}
\class_alias('_PhpScoper88fe6e0ad041\\SomeFormType', 'SomeFormType', \false);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScoper88fe6e0ad041\\Nette\\Application\\UI\\Control')) {
            return null;
        }
        foreach ($node->getMethods() as $classMethod) {
            if (!$this->isName($classMethod->name, 'createComponent*')) {
                continue;
            }
            $formTypeClass = $this->collectFormMethodCallsAndCreateFormTypeClass($classMethod);
            if ($formTypeClass === null) {
                continue;
            }
            $symfonyControllerNamespace = $this->symfonyControllerFactory->createNamespace($node, $formTypeClass);
            if ($symfonyControllerNamespace === null) {
                continue;
            }
            /** @var SmartFileInfo $smartFileInfo */
            $smartFileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
            $filePath = \dirname($smartFileInfo->getRealPath()) . \DIRECTORY_SEPARATOR . 'SomeFormController.php';
            $this->printToFile([$symfonyControllerNamespace], $filePath);
            return $formTypeClass;
        }
        return $node;
    }
    private function collectFormMethodCallsAndCreateFormTypeClass(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Stmt\Class_
    {
        $onFormVariableMethodCalls = $this->onFormVariableMethodCallsCollector->collectFromClassMethod($classMethod);
        if ($onFormVariableMethodCalls === []) {
            return null;
        }
        $formBuilderVariable = new \PhpParser\Node\Expr\Variable('formBuilder');
        // public function buildForm(\Symfony\Component\Form\FormBuilderInterface $formBuilder, array $options)
        $buildFormClassMethod = $this->createBuildFormClassMethod($formBuilderVariable);
        $symfonyMethodCalls = [];
        // create symfony form from nette form method calls
        foreach ($onFormVariableMethodCalls as $onFormVariableMethodCall) {
            if ($this->isName($onFormVariableMethodCall->name, 'addText')) {
                // text input
                $inputName = $onFormVariableMethodCall->args[0];
                $formTypeClassConstant = $this->createClassConstantReference(\_PhpScoper88fe6e0ad041\Symfony\Component\Form\Extension\Core\Type\TextType::class);
                $args = $this->createAddTextArgs($inputName, $formTypeClassConstant, $onFormVariableMethodCall);
                $methodCall = new \PhpParser\Node\Expr\MethodCall($formBuilderVariable, 'add', $args);
                $symfonyMethodCalls[] = new \PhpParser\Node\Stmt\Expression($methodCall);
            }
        }
        $buildFormClassMethod->stmts = $symfonyMethodCalls;
        return $this->createFormTypeClassFromBuildFormClassMethod($buildFormClassMethod);
    }
    private function createBuildFormClassMethod(\PhpParser\Node\Expr\Variable $formBuilderVariable) : \PhpParser\Node\Stmt\ClassMethod
    {
        $buildFormClassMethod = $this->nodeFactory->createPublicMethod('buildForm');
        $buildFormClassMethod->params[] = new \PhpParser\Node\Param($formBuilderVariable, null, new \PhpParser\Node\Name\FullyQualified('_PhpScoper88fe6e0ad041\\Symfony\\Component\\Form\\FormBuilderInterface'));
        $buildFormClassMethod->params[] = new \PhpParser\Node\Param(new \PhpParser\Node\Expr\Variable('options'), null, new \PhpParser\Node\Identifier('array'));
        return $buildFormClassMethod;
    }
    /**
     * @return Arg[]
     */
    private function createAddTextArgs(\PhpParser\Node\Arg $arg, \PhpParser\Node\Expr\ClassConstFetch $classConstFetch, \PhpParser\Node\Expr\MethodCall $onFormVariableMethodCall) : array
    {
        $args = [$arg, new \PhpParser\Node\Arg($classConstFetch)];
        if (isset($onFormVariableMethodCall->args[1])) {
            $optionsArray = new \PhpParser\Node\Expr\Array_([new \PhpParser\Node\Expr\ArrayItem($onFormVariableMethodCall->args[1]->value, new \PhpParser\Node\Scalar\String_('label'))]);
            $args[] = new \PhpParser\Node\Arg($optionsArray);
        }
        return $args;
    }
    private function createFormTypeClassFromBuildFormClassMethod(\PhpParser\Node\Stmt\ClassMethod $buildFormClassMethod) : \PhpParser\Node\Stmt\Class_
    {
        $formTypeClass = new \PhpParser\Node\Stmt\Class_('SomeFormType');
        $formTypeClass->extends = new \PhpParser\Node\Name\FullyQualified('_PhpScoper88fe6e0ad041\\Symfony\\Component\\Form\\AbstractType');
        $formTypeClass->stmts[] = $buildFormClassMethod;
        return $formTypeClass;
    }
}
