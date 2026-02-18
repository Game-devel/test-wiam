<?php

declare(strict_types=1);

namespace backend\dto;

final class CreateLoanRequestResponseDto
{
    public function __construct(
        public readonly bool $result,
        public readonly ?int $id = null,
        public readonly int $httpStatusCode = 200,
    ) {
    }

    public static function success(int $id, int $httpStatusCode = 201): self
    {
        return new self(true, $id, $httpStatusCode);
    }

    public static function failure(int $httpStatusCode = 400): self
    {
        return new self(false, null, $httpStatusCode);
    }
}

