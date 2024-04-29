<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\CodeQuality\Rector\Identical\SimplifyConditionsRector;
use Rector\CodeQuality\Rector\If_\CombineIfRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector;
use Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php81\Rector\ClassMethod\NewInInitializerRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\BooleanNot\BooleanInBooleanNotRuleFixerRector;
use Rector\Strict\Rector\If_\BooleanInIfConditionRuleFixerRector;
use Rector\Strict\Rector\Ternary\BooleanInTernaryOperatorRuleFixerRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/database',
        __DIR__ . '/config',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->parallel();
    $rectorConfig->cacheClass(FileCacheStorage::class);
    $rectorConfig->cacheDirectory('./storage/framework/cache/CI/rector');

    // conditions
    $rectorConfig->rule(ExplicitBoolCompareRector::class);
    $rectorConfig->rule(SimplifyConditionsRector::class);
    $rectorConfig->rule(SwitchNegatedTernaryRector::class);
    $rectorConfig->rule(RemoveAlwaysTrueIfConditionRector::class);
    $rectorConfig->rule(RemoveDeadConditionAboveReturnRector::class);
    $rectorConfig->rule(RemoveAlwaysElseRector::class);
    $rectorConfig->ruleWithConfiguration(BooleanInBooleanNotRuleFixerRector::class, [
        BooleanInBooleanNotRuleFixerRector::TREAT_AS_NON_EMPTY => true,
    ]);
    $rectorConfig->ruleWithConfiguration(BooleanInIfConditionRuleFixerRector::class, [
        BooleanInIfConditionRuleFixerRector::TREAT_AS_NON_EMPTY => false,
    ]);
    $rectorConfig->ruleWithConfiguration(BooleanInTernaryOperatorRuleFixerRector::class, [
        BooleanInTernaryOperatorRuleFixerRector::TREAT_AS_NON_EMPTY => false,
    ]);

    $rectorConfig->rule(FlipTypeControlToUseExclusiveTypeRector::class);
    $rectorConfig->rule(WrapEncapsedVariableInCurlyBracesRector::class);

    // php8 constructor style
    $rectorConfig->rule(NewInInitializerRector::class);
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);
    $rectorConfig->rule(ReadOnlyPropertyRector::class);
    $rectorConfig->ruleWithConfiguration(ClassPropertyAssignToConstructorPromotionRector::class, [
        ClassPropertyAssignToConstructorPromotionRector::INLINE_PUBLIC => false,
    ]);

    // EARLY_RETURN
    $rectorConfig->rule(CombineIfRector::class);
    $rectorConfig->sets([
        SetList::EARLY_RETURN,
    ]);
};
