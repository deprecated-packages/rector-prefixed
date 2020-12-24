<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteToSymfony\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NetteToSymfony\Collector\OnFormVariableMethodCallsCollector;
use _PhpScopere8e811afab72\Rector\NetteToSymfony\NodeFactory\SymfonyControllerFactory;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symfony\Component\Form\Extension\Core\Type\TextType;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see https://symfony.com/doc/current/forms.html#creating-form-classes
 *
 * @see \Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\FormControlToControllerAndFormTypeRectorTest
 */
final class FormControlToControllerAndFormTypeRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var OnFormVariableMethodCallsCollector
     */
    private $onFormVariableMethodCallsCollector;
    /**
     * @var SymfonyControllerFactory
     */
    private $symfonyControllerFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\NetteToSymfony\Collector\OnFormVariableMethodCallsCollector $onFormVariableMethodCallsCollector, \_PhpScopere8e811afab72\Rector\NetteToSymfony\NodeFactory\SymfonyControllerFactory $symfonyControllerFactory)
    {
        $this->onFormVariableMethodCallsCollector = $onFormVariableMethodCallsCollector;
        $this->symfonyControllerFactory = $symfonyControllerFactory;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Form that extends Control to Controller and decoupled FormType', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ExtraFileCodeSample(<<<'CODE_SAMPLE'
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

namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Symfony\Component\Form\AbstractType;
use _PhpScopere8e811afab72\Symfony\Component\Form\Extension\Core\Type\TextType;
use _PhpScopere8e811afab72\Symfony\Component\Form\FormBuilderInterface;
class SomeFormType extends \_PhpScopere8e811afab72\Symfony\Component\Form\AbstractType
{
    public function buildForm(\_PhpScopere8e811afab72\Symfony\Component\Form\FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder->add('name', \_PhpScopere8e811afab72\Symfony\Component\Form\Extension\Core\Type\TextType::class, ['label' => 'Your name']);
    }
}
\class_alias('_PhpScopere8e811afab72\\SomeFormType', 'SomeFormType', \false);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScopere8e811afab72\\Nette\\Application\\UI\\Control')) {
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
            $smartFileInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
            $filePath = \dirname($smartFileInfo->getRealPath()) . \DIRECTORY_SEPARATOR . 'SomeFormController.php';
            $this->printToFile([$symfonyControllerNamespace], $filePath);
            return $formTypeClass;
        }
        return $node;
    }
    private function collectFormMethodCallsAndCreateFormTypeClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        $onFormVariableMethodCalls = $this->onFormVariableMethodCallsCollector->collectFromClassMethod($classMethod);
        if ($onFormVariableMethodCalls === []) {
            return null;
        }
        $formBuilderVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('formBuilder');
        // public function buildForm(\Symfony\Component\Form\FormBuilderInterface $formBuilder, array $options)
        $buildFormClassMethod = $this->createBuildFormClassMethod($formBuilderVariable);
        $symfonyMethodCalls = [];
        // create symfony form from nette form method calls
        foreach ($onFormVariableMethodCalls as $onFormVariableMethodCall) {
            if ($this->isName($onFormVariableMethodCall->name, 'addText')) {
                // text input
                $inputName = $onFormVariableMethodCall->args[0];
                $formTypeClassConstant = $this->createClassConstantReference(\_PhpScopere8e811afab72\Symfony\Component\Form\Extension\Core\Type\TextType::class);
                $args = $this->createAddTextArgs($inputName, $formTypeClassConstant, $onFormVariableMethodCall);
                $methodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($formBuilderVariable, 'add', $args);
                $symfonyMethodCalls[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($methodCall);
            }
        }
        $buildFormClassMethod->stmts = $symfonyMethodCalls;
        return $this->createFormTypeClassFromBuildFormClassMethod($buildFormClassMethod);
    }
    private function createBuildFormClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $formBuilderVariable) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $buildFormClassMethod = $this->nodeFactory->createPublicMethod('buildForm');
        $buildFormClassMethod->params[] = new \_PhpScopere8e811afab72\PhpParser\Node\Param($formBuilderVariable, null, new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\FormBuilderInterface'));
        $buildFormClassMethod->params[] = new \_PhpScopere8e811afab72\PhpParser\Node\Param(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('options'), null, new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('array'));
        return $buildFormClassMethod;
    }
    /**
     * @return Arg[]
     */
    private function createAddTextArgs(\_PhpScopere8e811afab72\PhpParser\Node\Arg $arg, \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch $classConstFetch, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $onFormVariableMethodCall) : array
    {
        $args = [$arg, new \_PhpScopere8e811afab72\PhpParser\Node\Arg($classConstFetch)];
        if (isset($onFormVariableMethodCall->args[1])) {
            $optionsArray = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_([new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem($onFormVariableMethodCall->args[1]->value, new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_('label'))]);
            $args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($optionsArray);
        }
        return $args;
    }
    private function createFormTypeClassFromBuildFormClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $buildFormClassMethod) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        $formTypeClass = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_('SomeFormType');
        $formTypeClass->extends = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\AbstractType');
        $formTypeClass->stmts[] = $buildFormClassMethod;
        return $formTypeClass;
    }
}
