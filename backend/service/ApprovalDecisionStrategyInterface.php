<?php

declare(strict_types=1);

namespace backend\service;

use common\models\LoanRequest;

/**
 * Strategy for deciding whether to approve a loan request (Strategy pattern, Open/Closed).
 */
interface ApprovalDecisionStrategyInterface
{
    /**
     * Whether the given pending request should be approved.
     * Caller must ensure user has at most one approved request.
     */
    public function shouldApprove(LoanRequest $request): bool;
}
