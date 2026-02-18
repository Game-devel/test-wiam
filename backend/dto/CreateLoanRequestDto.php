<?php

declare(strict_types=1);

namespace backend\dto;

/**
 * DTO for loan request submission (POST /requests).
 */
final class CreateLoanRequestDto
{
    public function __construct(
        public readonly int $userId,
        public readonly int $amount,
        public readonly int $term,
    ) {
    }

    public static function fromRequest(array $data): ?self
    {
        if (
            !isset($data['user_id'], $data['amount'], $data['term'])
            || !is_numeric($data['user_id'])
            || !is_numeric($data['amount'])
            || !is_numeric($data['term'])
        ) {
            return null;
        }

        $userId = (int) $data['user_id'];
        $amount = (int) $data['amount'];
        $term = (int) $data['term'];

        if ($amount <= 0 || $term <= 0) {
            return null;
        }

        return new self($userId, $amount, $term);
    }
}
