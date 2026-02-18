<?php

declare(strict_types=1);

namespace backend\service;

use common\models\LoanRequest;

/**
 * Random approval strategy: 10% probability of approval (per ТЗ).
 */
final class RandomApprovalDecisionStrategy implements ApprovalDecisionStrategyInterface
{
    private const APPROVAL_PROBABILITY = 0.1;

    public function shouldApprove(LoanRequest $request): bool
    {
        return (mt_rand() / mt_getrandmax()) < self::APPROVAL_PROBABILITY;
    }
}
