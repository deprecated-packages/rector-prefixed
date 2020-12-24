<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Sensio\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Instanceof_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Sensio\NodeFactory\ThisRenderFactory;
use _PhpScopere8e811afab72\Rector\Sensio\TypeAnalyzer\ArrayUnionResponseTypeAnalyzer;
use _PhpScopere8e811afab72\Rector\Sensio\TypeDeclaration\ReturnTypeDeclarationUpdater;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony-docs/pull/12387#discussion_r329551967
 * @see https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/view.html
 * @see https://github.com/sensiolabs/SensioFrameworkExtraBundle/issues/641
 *
 * @see \Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector\TemplateAnnotationToThisRenderRectorTest
 */
final class TemplateAnnotationToThisRenderRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const RESPONSE_CLASS = '_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\Response';
    /**
     * @var ReturnTypeDeclarationUpdater
     */
    private $returnTypeDeclarationUpdater;
    /**
     * @var ThisRenderFactory
     */
    private $thisRenderFactory;
    /**
     * @var ArrayUnionResponseTypeAnalyzer
     */
    private $arrayUnionResponseTypeAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\Sensio\TypeAnalyzer\ArrayUnionResponseTypeAnalyzer $arrayUnionResponseTypeAnalyzer, \_PhpScopere8e811afab72\Rector\Sensio\TypeDeclaration\ReturnTypeDeclarationUpdater $returnTypeDeclarationUpdater, \_PhpScopere8e811afab72\Rector\Sensio\NodeFactory\ThisRenderFactory $thisRenderFactory)
    {
        $this->returnTypeDeclarationUpdater = $returnTypeDeclarationUpdater;
        $this->thisRenderFactory = $thisRenderFactory;
        $this->arrayUnionResponseTypeAnalyzer = $arrayUnionResponseTypeAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns `@Template` annotation to explicit method call in Controller of FrameworkExtraBundle in Symfony', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
/**
 * @Template()
 */
public function indexAction()
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
public function indexAction()
{
    return $this->render('index.html.twig');
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_|ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return $this->addAbstractControllerParentClassIfMissing($node);
        }
        return $this->replaceTemplateAnnotation($node);
    }
    private function addAbstractControllerParentClassIfMissing(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        if ($class->extends !== null) {
            return null;
        }
        if (!$this->classHasTemplateAnnotations($class)) {
            return null;
        }
        $class->extends = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController');
        return $class;
    }
    private function replaceTemplateAnnotation(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$classMethod->isPublic()) {
            return null;
        }
        /** @var SensioTemplateTagValueNode|null $sensioTemplateTagValueNode */
        $sensioTemplateTagValueNode = $this->getPhpDocTagValueNode($classMethod, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class);
        if ($sensioTemplateTagValueNode === null) {
            return null;
        }
        $this->refactorClassMethod($classMethod, $sensioTemplateTagValueNode);
        return $classMethod;
    }
    private function classHasTemplateAnnotations(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        foreach ($class->getMethods() as $classMethod) {
            if ($this->hasPhpDocTagValueNode($classMethod, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class)) {
                return \true;
            }
        }
        return \false;
    }
    private function refactorClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode) : void
    {
        /** @var Return_[] $returns */
        $returns = $this->findReturnsInCurrentScope((array) $classMethod->stmts);
        $hasThisRenderOrReturnsResponse = $this->hasLastReturnResponse($classMethod);
        foreach ($returns as $return) {
            $this->refactorReturn($return, $classMethod, $sensioTemplateTagValueNode, $hasThisRenderOrReturnsResponse);
        }
        if ($returns === []) {
            $thisRenderMethodCall = $this->thisRenderFactory->create($classMethod, null, $sensioTemplateTagValueNode);
            $this->refactorNoReturn($classMethod, $thisRenderMethodCall);
        }
    }
    /**
     * This skips anonymous functions and functions, as their returns doesn't influence current code
     *
     * @param Node[] $stmts
     * @return Return_[]
     */
    private function findReturnsInCurrentScope(array $stmts) : array
    {
        $returns = [];
        $this->traverseNodesWithCallable($stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$returns) : ?int {
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_) {
                return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
                return null;
            }
            $returns[] = $node;
            return null;
        });
        return $returns;
    }
    private function hasLastReturnResponse(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var Return_|null $lastReturn */
        $lastReturn = $this->betterNodeFinder->findLastInstanceOf((array) $classMethod->stmts, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_::class);
        if ($lastReturn === null) {
            return \false;
        }
        return $this->isReturnOfObjectType($lastReturn, self::RESPONSE_CLASS);
    }
    private function refactorReturn(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ $return, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode, bool $hasThisRenderOrReturnsResponse) : void
    {
        // nothing we can do
        if ($return->expr === null) {
            return;
        }
        // create "$this->render('template.file.twig.html', ['key' => 'value']);" method call
        $thisRenderMethodCall = $this->thisRenderFactory->create($classMethod, $return, $sensioTemplateTagValueNode);
        $this->refactorReturnWithValue($return, $hasThisRenderOrReturnsResponse, $thisRenderMethodCall, $classMethod);
    }
    private function refactorNoReturn(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $thisRenderMethodCall) : void
    {
        $this->processClassMethodWithoutReturn($classMethod, $thisRenderMethodCall);
        $this->returnTypeDeclarationUpdater->updateClassMethod($classMethod, self::RESPONSE_CLASS);
        $this->removePhpDocTagValueNode($classMethod, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class);
    }
    private function refactorReturnWithValue(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ $return, bool $hasThisRenderOrReturnsResponse, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $thisRenderMethodCall, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var Expr $lastReturnExpr */
        $lastReturnExpr = $return->expr;
        $returnStaticType = $this->getStaticType($lastReturnExpr);
        if (!$return->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            if (!$hasThisRenderOrReturnsResponse || $returnStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
                $return->expr = $thisRenderMethodCall;
            }
        } elseif ($returnStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            $return->expr = $thisRenderMethodCall;
        } elseif ($returnStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            // nothing we can do
            return;
        }
        $isArrayOrResponseType = $this->arrayUnionResponseTypeAnalyzer->isArrayUnionResponseType($returnStaticType, self::RESPONSE_CLASS);
        if ($isArrayOrResponseType) {
            $this->processIsArrayOrResponseType($return, $lastReturnExpr, $thisRenderMethodCall);
        }
        $this->returnTypeDeclarationUpdater->updateClassMethod($classMethod, self::RESPONSE_CLASS);
        $this->removePhpDocTagValueNode($classMethod, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class);
    }
    private function processClassMethodWithoutReturn(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $thisRenderMethodCall) : void
    {
        $classMethod->stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($thisRenderMethodCall);
    }
    private function processIsArrayOrResponseType(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ $return, \_PhpScopere8e811afab72\PhpParser\Node\Expr $returnExpr, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $thisRenderMethodCall) : void
    {
        $this->removeNode($return);
        // create instance of Response → return response, or return $this->render
        $responseVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('responseOrData');
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($responseVariable, $returnExpr);
        $if = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Instanceof_($responseVariable, new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified(self::RESPONSE_CLASS)));
        $if->stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($responseVariable);
        $thisRenderMethodCall->args[1] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($responseVariable);
        $returnThisRender = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($thisRenderMethodCall);
        $this->addNodesAfterNode([$assign, $if, $returnThisRender], $return);
    }
}
