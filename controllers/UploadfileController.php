<?php


namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Uploadfile;
use yii\web\UploadedFile;

class UploadfileController extends Controller
{
    public function actionIndex()
    {
        $model = new Uploadfile();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload()) {

                return $this->render('index', ['model' => $model]);
            }
        }

        return $this->render('index', ['model' => $model]);
    }
}