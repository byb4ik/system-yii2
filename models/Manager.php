<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "managers".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $esp_id
 * @property int|null $value
 * @property int|null $count
 * @property int|null $sum
 */
class Manager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'managers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'esp_id', 'value', 'count', 'sum'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Торговый представитель',
            'esp_id' => 'Данные по напитку',
            'value' => 'Объем кеги',
            'count' => 'Кол-во кег',
            'sum' => 'Итого',
        ];
    }
}
