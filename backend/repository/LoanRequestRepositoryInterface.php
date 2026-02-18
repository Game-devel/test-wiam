<?php

declare(strict_types=1);

namespace backend\repository;

use common\models\LoanRequest;

/**
 * Repository interface for loan request persistence (Dependency Inversion).
 */
interface LoanRequestRepositoryInterface
{
    public function userHasApprovedRequest(int $userId): bool;

    /**
     * @return LoanRequest[]
     */
    public function findPendingOrderById(): array;

    public function save(LoanRequest $loanRequest): bool;

    public function create(int $userId, int $amount, int $term): LoanRequest;
}
