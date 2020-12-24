<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Php70\Rector\Assign\ListSplitStringRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\Assign\ListSwapArrayOrderRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\Break_\BreakNotInLoopOrSwitchToReturnRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\ClassMethod\Php4ConstructorRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\CallUserMethodRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\EregToPregMatchRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\MultiDirnameRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\NonVariableToVariableOnFunctionCallRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\RandomFunctionRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\RenameMktimeWithoutArgsToTimeRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\FunctionLike\ExceptionHandlerTypehintRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\If_\IfToSpaceshipRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\List_\EmptyListRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\Ternary\TernaryToSpaceshipRector;
use _PhpScoperb75b35f52b74\Rector\Php70\Rector\Variable\WrapVariableVariableNameInCurlyBracesRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/mysql-to-mysqli.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\ClassMethod\Php4ConstructorRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\RandomFunctionRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\FunctionLike\ExceptionHandlerTypehintRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\MultiDirnameRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\Assign\ListSplitStringRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\List_\EmptyListRector::class);
    # be careful, run this just once, since it can keep swapping order back and forth
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\Assign\ListSwapArrayOrderRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\CallUserMethodRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\EregToPregMatchRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\Ternary\TernaryToSpaceshipRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\Variable\WrapVariableVariableNameInCurlyBracesRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\If_\IfToSpaceshipRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\Break_\BreakNotInLoopOrSwitchToReturnRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\RenameMktimeWithoutArgsToTimeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php70\Rector\FuncCall\NonVariableToVariableOnFunctionCallRector::class);
};
