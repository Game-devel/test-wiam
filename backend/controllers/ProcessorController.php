<?php

declare(strict_types=1);

namespace backend\controllers;

use backend\service\LoanRequestProcessorService;
use Yii;

class ProcessorController extends BaseController
{
    public function __construct(
        $id,
        $module,
        private readonly LoanRequestProcessorService $processorService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['verbFilter']['actions'] = [
            'index' => ['get'],
        ];

        return $behaviors;
    }

    /**
     * @return array
     */
    public function actionIndex(): array
    {
        $delay = (int) (Yii::$app->request->get('delay', 0) ?: 0);

        $this->processorService->process($delay);

        return $this->successResponse();
    }
}
