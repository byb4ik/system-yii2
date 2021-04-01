<?php

namespace app\models;


use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "esp".
 *
 * @property int $id
 * @property int $user_id
 * @property int $market_point
 * @property int $valve
 * @property float|null $liter_base
 * @property float|null $liter_balance
 * @property float|null $liter_all_time
 * @property float|null $liter_from_esp
 * @property string $customer
 * @property string $address
 * @property string $drink_name
 * @property string $customer_name
 * @property string $esp_date_import
 * @property string $esp_last_date
 * @property int $mail_percent
 * @property string $summ_7days
 * @property int $price_buy
 * @property int $price_sale
 * @property int $avrg_day
 * @property int $day_from_table
 * @property int $timer_set
 *
 */
class Esp extends \yii\db\ActiveRecord
{
    public $day_from_table;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'esp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'valve'], 'required'],
            [['user_id', 'valve', 'mail_percent', 'price_buy', 'price_sale', 'avrg_day', 'day_from_table', 'hour_to_exp', 'sent_mail_exp', 'timer_set', 'market_point'], 'integer'],
            [['liter_base', 'liter_balance', 'liter_all_time', 'liter_from_esp'], 'number'],
            [['customer', 'address', 'drink_name', 'customer_name'], 'string', 'max' => 255],
            [['esp_date_import', 'esp_last_date'], 'string', 'max' => 100],
            [['summ_7days'], 'string'],
            [['avrg_day'], 'default', 'value' => 7],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID Пользователя',
            'market_point' => 'Торговая точка',
            'valve' => 'Кран',
            'liter_base' => 'Литр Склад',
            'liter_balance' => 'Литр Остаток',
            'liter_all_time' => 'Литр За Все Время',
            'liter_from_esp' => 'Литр ESP',
            'customer' => 'Покупатель',
            'address' => 'Адрес',
            'drink_name' => 'Наименование',
            'customer_name' => 'ООО/ИП',
            'esp_date_import' => 'Дата Импорта ЕСП',
            'esp_last_date' => 'Последнее значение ЕСП',
            'mail_percent' => 'Процент для оповещения E-mail',
            'price_buy' => 'Цена закупки',
            'price_sale' => 'Цена продажи',
            'avrg_day' => 'Количество дней для сред значения',
            'data_set_storage' => 'Дата установки кеги',
            'data_exp_storage' => 'Конечный срок реализации',
            'hour_to_exp' => 'Срок реализации(ч)',
            'sent_mail_exp' => 'Письмо отправлено',

        ];
    }

    public function getAllEspByUser()
    {
        return self::find()->where(['user_id' => Yii::$app->user->getId()])->asArray()->all();
    }

    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public function getMarket()
    {
        return $this->hasOne(Users::class, ['id' => 'market_point']);
    }

    public function getAllUsers()
    {
        return ArrayHelper::map(Users::find()->all(), 'id', 'name_surname');
    }

    public function getAllPoints()
    {
        return ArrayHelper::map(Users::find()->where(['behaviors' => 5])->all(), 'id', 'name_surname');
    }

    public function getId($customer, $address, $drink_name)
    {
        return self::find()->where(['customer' => $customer, 'address' => $address, 'drink_name' => $drink_name])->one()->attributes['id'];
    }

    public function setlbase($value)
    {
        return $this->liter_base = $this->liter_balance + $value;
    }

    public function setlbalance($value)
    {
        return $this->liter_balance = $this->liter_balance + $value;
    }

    public function getUniqDrink($id = null)
    {
        if (isset($id) && !empty($id)) {
            return array_unique(ArrayHelper::map(Esp::find()->where(['user_id' => $id])->asArray()->all(), 'drink_name', 'drink_name'), SORT_STRING);
        }

        return array_unique(ArrayHelper::map(Esp::find()->asArray()->all(), 'drink_name', 'drink_name'), SORT_STRING);
    }

    public function getUniqCustomerName($id = null)
    {
        if (isset($id) && !empty($id)) {
            return array_unique(ArrayHelper::map(Esp::find()->where(['user_id' => $id])->asArray()->all(), 'customer_name', 'customer_name'), SORT_STRING);
        }

        return array_unique(ArrayHelper::map(Esp::find()->asArray()->all(), 'customer_name', 'customer_name'), SORT_STRING);
    }

    public function getUniqAddress($id = null)
    {
        if (isset($id) && !empty($id)) {
            return array_unique(ArrayHelper::map(Esp::find()->where(['user_id' => $id])->asArray()->all(), 'address', 'address'), SORT_STRING);
        }

        return array_unique(ArrayHelper::map(Esp::find()->asArray()->all(), 'address', 'address'), SORT_STRING);
    }

    public function getFilterValue(): array
    {
        return ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '9' => '9', '14' => '14'];
    }

    public function getAvrgValue()
    {
        if (!empty($this->summ_7days)) {
            $arr = json_decode($this->summ_7days, true);
            $arr = array_slice($arr, '-' . $this->avrg_day, $this->avrg_day);

            return round(array_sum($arr) / $this->avrg_day, 2);
        }

        return null;
    }

    public function colorValve(): ?bool
    {
        if (!empty($this->summ_7days)) {
            $arr = json_decode($this->summ_7days, true);
            $arr = array_slice($arr, '-' . $this->avrg_day * 2, $this->avrg_day * 2);
            //прошлая неделя
            $arr_prev = array_splice($arr, 0, '-' . $this->avrg_day);
            //текущая неделя
            $arr_current = array_slice($arr, '-' . $this->avrg_day, $this->avrg_day);
            if (array_sum($arr_prev) < array_sum($arr_current)) {
                return true;
            } else {
                return false;
            }
        }

        return null;
    }

    public function getSumDrink(array $drink_arr)
    {
        $res = [];
        foreach ($drink_arr as $drink => $group) {
            $all_record = ArrayHelper::getColumn(Esp::find()->where(['drink_name' => $drink])->all(), 'summ_7days');
            foreach ($all_record as $one_rec) {
                if (empty($res[$group])) {
                    $res[$group] = array_sum(json_decode($one_rec, true));
                } else {
                    $res[$group] += array_sum(json_decode($one_rec, true));
                }
            }
        }
        foreach ($res as $key => $result) {
            $arr_for_graph[] = ['name' => $key, 'data' => [$result]];
        }

        return array_values($arr_for_graph);
    }

}
