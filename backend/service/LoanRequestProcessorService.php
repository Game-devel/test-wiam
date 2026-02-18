<?php

declare(strict_types=1);

namespace backend\service;

use backend\repository\LoanRequestRepositoryInterface;
use common\models\LoanRequest;

/**
 * Application service: process pending loan requests with delay and random approval (ТЗ).
 */
final class LoanRequestProcessorService
{
    private const DELAY_MAX_SECONDS = 300;

    public function __construct(
        private readonly LoanRequestRepositoryInterface $repository,
        private readonly ApprovalDecisionStrategyInterface $decisionStrategy,
    ) {
    }

    /**
     * Process all pending requests: sleep(delay) per request, then approve/decline (10% approve).
     * One user cannot have more than one approved request (handles parallel calls).
     */
    public function process(int $delaySeconds): void
    {
        $delay = max(0, min($delaySeconds, self::DELAY_MAX_SECONDS));
        $requests = $this->repository->findPendingOrderById();

        foreach ($requests as $request) {
            sleep($delay);

            $shouldApprove = $this->decisionStrategy->shouldApprove($request)
                && !$this->repository->userHasApprovedRequest($request->user_id);

            $request->status = $shouldApprove
                ? LoanRequest::STATUS_APPROVED
                : LoanRequest::STATUS_DECLINED;

            try {
                $this->repository->save($request);
            } catch (\Exception $exception) {
                $request->status = LoanRequest::STATUS_DECLINED;
                $this->repository->save($request);
            }
        }
    }
}
