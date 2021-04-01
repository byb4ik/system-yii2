<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "drink".
 *
 * @property int $id
 * @property string|null $drink
 * @property int|null $group
 */
class Drink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drink';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['drink', 'group'], 'string', 'max' => 255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'drink' => 'Напиток',
            'group' => 'Группа',
        ];
    }

    public function getAllDrinks()
    {
        return ArrayHelper::map(Drink::find()->all(), 'drink', 'group');
    }
}
