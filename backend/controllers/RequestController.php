<?php

declare(strict_types=1);

namespace backend\controllers;

use backend\dto\CreateLoanRequestDto;
use backend\service\LoanRequestSubmitService;
use Yii;
use yii\web\Response;

class RequestController extends BaseController
{
    public function __construct(
        $id,
        $module,
        private readonly LoanRequestSubmitService $submitService,
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
            'create' => ['post'],
        ];

        return $behaviors;
    }

    /**
     * @return array
     */
    public function actionCreate(): array
    {
        $dto = CreateLoanRequestDto::fromRequest(Yii::$app->request->post());

        if ($dto === null) {
            return $this->errorResponse(400);
        }

        $response = $this->submitService->submit($dto);

        if (!$response->result) {
            return $this->errorResponse($response->httpStatusCode);
        }

        return $this->successResponse($response->id, $response->httpStatusCode);
    }
}
