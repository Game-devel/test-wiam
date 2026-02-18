<?php

declare(strict_types=1);

namespace backend\bootstrap;

use backend\repository\LoanRequestRepository;
use backend\repository\LoanRequestRepositoryInterface;
use backend\service\ApprovalDecisionStrategyInterface;
use backend\service\RandomApprovalDecisionStrategy;
use Yii;
use yii\base\BootstrapInterface;

final class ContainerBootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(
            LoanRequestRepositoryInterface::class,
            ['class' => LoanRequestRepository::class]
        );

        $container->setSingleton(
            ApprovalDecisionStrategyInterface::class,
            ['class' => RandomApprovalDecisionStrategy::class]
        );
    }
}
