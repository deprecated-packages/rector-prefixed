<?php

declare (strict_types=1);
namespace RectorPrefix20210501;

use Rector\Transform\Rector\FuncCall\FuncCallToStaticCallRector;
use Rector\Transform\ValueObject\FuncCallToStaticCall;
use RectorPrefix20210501\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
// @see https://medium.freecodecamp.org/moving-away-from-magic-or-why-i-dont-want-to-use-laravel-anymore-2ce098c979bd
// @see https://laravel.com/docs/5.7/facades#facades-vs-dependency-injection
return static function (\RectorPrefix20210501\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\FuncCall\FuncCallToStaticCallRector::class)->call('configure', [[\Rector\Transform\Rector\FuncCall\FuncCallToStaticCallRector::FUNC_CALLS_TO_STATIC_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_add', 'Illuminate\\Support\\Arr', 'add'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_collapse', 'Illuminate\\Support\\Arr', 'collapse'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_divide', 'Illuminate\\Support\\Arr', 'divide'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_dot', 'Illuminate\\Support\\Arr', 'dot'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_except', 'Illuminate\\Support\\Arr', 'except'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_first', 'Illuminate\\Support\\Arr', 'first'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_flatten', 'Illuminate\\Support\\Arr', 'flatten'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_forget', 'Illuminate\\Support\\Arr', 'forget'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_get', 'Illuminate\\Support\\Arr', 'get'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_has', 'Illuminate\\Support\\Arr', 'has'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_last', 'Illuminate\\Support\\Arr', 'last'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_only', 'Illuminate\\Support\\Arr', 'only'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_pluck', 'Illuminate\\Support\\Arr', 'pluck'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_prepend', 'Illuminate\\Support\\Arr', 'prepend'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_pull', 'Illuminate\\Support\\Arr', 'pull'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_random', 'Illuminate\\Support\\Arr', 'random'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_sort', 'Illuminate\\Support\\Arr', 'sort'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_sort_recursive', 'Illuminate\\Support\\Arr', 'sortRecursive'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_where', 'Illuminate\\Support\\Arr', 'where'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_wrap', 'Illuminate\\Support\\Arr', 'wrap'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('array_set', 'Illuminate\\Support\\Arr', 'set'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('camel_case', 'Illuminate\\Support\\Str', 'camel'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('ends_with', 'Illuminate\\Support\\Str', 'endsWith'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('kebab_case', 'Illuminate\\Support\\Str', 'kebab'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('snake_case', 'Illuminate\\Support\\Str', 'snake'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('starts_with', 'Illuminate\\Support\\Str', 'startsWith'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_after', 'Illuminate\\Support\\Str', 'after'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_before', 'Illuminate\\Support\\Str', 'before'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_contains', 'Illuminate\\Support\\Str', 'contains'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_finish', 'Illuminate\\Support\\Str', 'finish'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_is', 'Illuminate\\Support\\Str', 'is'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_limit', 'Illuminate\\Support\\Str', 'limit'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_plural', 'Illuminate\\Support\\Str', 'plural'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_random', 'Illuminate\\Support\\Str', 'random'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_replace_array', 'Illuminate\\Support\\Str', 'replaceArray'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_replace_first', 'Illuminate\\Support\\Str', 'replaceFirst'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_replace_last', 'Illuminate\\Support\\Str', 'replaceLast'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_singular', 'Illuminate\\Support\\Str', 'singular'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_slug', 'Illuminate\\Support\\Str', 'slug'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('str_start', 'Illuminate\\Support\\Str', 'start'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('studly_case', 'Illuminate\\Support\\Str', 'studly'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('title_case', 'Illuminate\\Support\\Str', 'title')])]]);
};
