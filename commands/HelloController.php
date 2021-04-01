<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Esp;
use DateTime;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\web\ServerErrorHttpException;


class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {

        //Yii::$app->mailer->getTransport()->start();

        $model = Esp::find()->where(['timer_set' => 1])->all();

        foreach ($model as $esp) {

            $origin = new DateTime(date("Y-m-d H:i:s"));
            $target = new DateTime($esp['data_exp_storage']);

            $interval = $origin->diff($target);

            if ($interval->d < 1 && $interval->invert < 1) {
                if ($interval->h < 20) {

                    Yii::$app->mailer->compose()
                        ->setFrom('pivo@gmail.com')
                        ->setTo($esp->market->mail)
                        ->setSubject('Срок заканчивается') // тема письма
                        //->setTextBody('Текстовая версия письма (без HTML)')
                        ->setHtmlBody('<h2>' . $esp->drink_name . '</h2><h3>срок <20ч</h3>')
                        ->send();

                    $esp->setAttributes(['timer_set' => 0]);
                    if ($esp->save() === false && !$esp->hasErrors()) {
                        throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
                    }
                }
            }
        }


    }
}
