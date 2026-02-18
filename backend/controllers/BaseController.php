<?php

declare(strict_types=1);

namespace backend\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;

abstract class BaseController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        unset($behaviors['authenticator']);

        return $behaviors;
    }

    /**
     *
     * @param int|null $id
     * @param int     $statusCode
     * @return array
     */
    protected function successResponse(?int $id = null, int $statusCode = 200): array
    {
        Yii::$app->response->statusCode = $statusCode;

        $data = ['result' => true];
        if ($id !== null) {
            $data['id'] = $id;
        }

        return $data;
    }

    /**
     *
     * @param int $statusCode
     * @return array
     */
    protected function errorResponse(int $statusCode = 400): array
    {
        Yii::$app->response->statusCode = $statusCode;

        return ['result' => false];
    }
}
