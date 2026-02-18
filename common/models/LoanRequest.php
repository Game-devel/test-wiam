<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Loan request model.
 *
 * @property int $id
 * @property int $user_id
 * @property int $amount
 * @property int $term
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class LoanRequest extends ActiveRecord
{
    public const STATUS_PENDING = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_DECLINED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%loan_request}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'amount', 'term'], 'required'],
            [['user_id', 'amount', 'term'], 'integer'],
            [['user_id', 'amount', 'term'], 'filter', 'filter' => 'intval'],
            [['amount', 'term'], 'compare', 'compareValue' => 0, 'operator' => '>'],
            ['status', 'in', 'range' => [self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_DECLINED]],
        ];
    }

    /**
     * Checks if user has an approved request.
     */
    public static function userHasApprovedRequest(int $userId): bool
    {
        return self::find()
            ->andWhere(['user_id' => $userId, 'status' => self::STATUS_APPROVED])
            ->exists();
    }

    /**
     * Finds pending requests for processing.
     *
     * @return LoanRequest[]
     */
    public static function findPendingRequests(): array
    {
        return self::find()
            ->andWhere(['status' => self::STATUS_PENDING])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }
}
