<?php

declare(strict_types=1);

namespace backend\service;

use backend\dto\CreateLoanRequestResponseDto;
use backend\dto\CreateLoanRequestDto;
use backend\repository\LoanRequestRepositoryInterface;
use common\models\LoanRequest;

/**
 * Application service: submit a new loan request (Single Responsibility).
 */
final class LoanRequestSubmitService
{
    public function __construct(
        private readonly LoanRequestRepositoryInterface $repository,
    ) {
    }

    /**
     * Submits a loan request. Validates: user must not have an approved request.
     *
     * @return CreateLoanRequestResponseDto success with id, or failure
     */
    public function submit(CreateLoanRequestDto $dto): CreateLoanRequestResponseDto
    {
        $model = $this->repository->create($dto->userId, $dto->amount, $dto->term);

        if (!$model->validate()) {
            return CreateLoanRequestResponseDto::failure();
        }

        if ($this->repository->userHasApprovedRequest($dto->userId)) {
            return CreateLoanRequestResponseDto::failure();
        }

        if (!$this->repository->save($model)) {
            return CreateLoanRequestResponseDto::failure(500);
        }

        return CreateLoanRequestResponseDto::success((int) $model->id);
    }
}
