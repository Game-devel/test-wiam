<?php

declare(strict_types=1);

namespace backend\repository;

use common\models\LoanRequest;

/**
 * Repository implementation for loan requests (ActiveRecord).
 * Uses application default db component for persistence.
 */
final class LoanRequestRepository implements LoanRequestRepositoryInterface
{

    /**
     * @inheritdoc
     */
    public function userHasApprovedRequest(int $userId): bool
    {
        return LoanRequest::find()
            ->andWhere(['user_id' => $userId, 'status' => LoanRequest::STATUS_APPROVED])
            ->exists();
    }

    /**
     * @inheritdoc
     * @return LoanRequest[]
     */
    public function findPendingOrderById(): array
    {
        return LoanRequest::find()
            ->andWhere(['status' => LoanRequest::STATUS_PENDING])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

    /**
     * @inheritdoc
     */
    public function save(LoanRequest $loanRequest): bool
    {
        return $loanRequest->save(false);
    }

    /**
     * @inheritdoc
     */
    public function create(int $userId, int $amount, int $term): LoanRequest
    {
        $model = new LoanRequest();
        $model->user_id = $userId;
        $model->amount = $amount;
        $model->term = $term;
        $model->status = LoanRequest::STATUS_PENDING;

        return $model;
    }
}
