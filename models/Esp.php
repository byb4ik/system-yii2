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
 * @property int $manager_id
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
 * @property int $request_value
 * @property int $request_count
 * @property int $request_sum
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
            [
                ['user_id', 'valve', 'mail_percent', 'price_buy', 'price_sale',
                    'avrg_day', 'day_from_table', 'hour_to_exp', 'sent_mail_exp',
                    'timer_set', 'market_point', 'manager_id', 'request_value',
                    'request_count', 'request_sum'],
                'integer'],
            [['liter_base', 'liter_balance', 'liter_all_time', 'liter_from_esp', 'avrg_value', 'customer'], 'number'],
            [['address', 'drink_name', 'customer_name'], 'string', 'max' => 255],
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
            'user_id' => 'ID ????????????????????????',
            'market_point' => '???????????????? ??????????',
            'manager_id' => '???????????????? ??????????????????????????',
            'valve' => '????????',
            'liter_base' => '???????? ??????????',
            'liter_balance' => '???????? ??????????????',
            'liter_all_time' => '???????? ???? ?????? ??????????',
            'liter_from_esp' => '???????? ESP',
            'customer' => '????????????????????',
            'address' => '??????????',
            'drink_name' => '????????????????????????',
            'customer_name' => '??????/????',
            'esp_date_import' => '???????? ?????????????? ??????',
            'esp_last_date' => '?????????????????? ???????????????? ??????',
            'mail_percent' => '?????????????? ?????? ???????????????????? E-mail',
            'price_buy' => '???????? ??????????????',
            'price_sale' => '???????? ??????????????',
            'avrg_day' => '???????????????????? ???????? ?????? ???????? ????????????????',
            'data_set_storage' => '???????? ?????????????????? ????????',
            'data_exp_storage' => '???????????????? ???????? ????????????????????',
            'hour_to_exp' => '???????? ????????????????????(??)',
            'sent_mail_exp' => '???????????? ????????????????????',
            'avrg_value' => '??????. ?? ??????????????',
            'request_value' => '?????????????? (??)',
            'request_count' => '?????????????? (????)',
            'request_sum' => '??????????',
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

    public function getManager()
    {
        return $this->hasOne(Users::class, ['id' => 'manager_id']);
    }

    public function getAllUsers()
    {
        return ArrayHelper::map(Users::find()->all(), 'id', 'name_surname');
    }

    public function getAllPoints()
    {
        return ArrayHelper::map(Users::find()->where(['behaviors' => 5])->all(), 'id', 'name_surname');
    }

    public function getAllManagers()
    {
        return ArrayHelper::map(Users::find()->where(['behaviors' => 15])->all(), 'id', 'name_surname');
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
            //?????????????? ????????????
            $arr_prev = array_splice($arr, 0, '-' . $this->avrg_day);
            //?????????????? ????????????
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
