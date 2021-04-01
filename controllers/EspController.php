<?php

namespace app\controllers;

use app\models\Users;
use Exception;
use http\Url;
use Yii;
use app\models\Esp;
use app\models\EspSearch;
use yii\data\ActiveDataProvider;
use yii\debug\models\timeline\Search;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;


/**
 * EspController implements the CRUD actions for Esp model.
 */
class EspController extends Controller
{

    /**
     * Lists all Esp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->checkAuth();
        $model = new Esp();
        $searchModel = new EspSearch();
        //для пользователя получаем id логина, получаем список по id
        if (5 == Users::findIdentity(Yii::$app->user->getId())->attributes['behaviors']){
            $query = Esp::find()->where(['market_point' => Yii::$app->user->id]);
        }
        if (10 == Users::findIdentity(Yii::$app->user->getId())->attributes['behaviors']){
            $query = Esp::find()->where(['user_id' => Yii::$app->user->id]);
        }
        if (1 == Users::findIdentity(Yii::$app->user->getId())->attributes['behaviors']){
            $query = Esp::find()->where(['user_id' => Yii::$app->user->id]);
        }
        $provider = $searchModel->search(Yii::$app->request->queryParams, $query);
        //для админа
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'data' => $provider,
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Esp model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->checkAuth();

        return $this->render('view', [

            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Esp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->checkAuth();

        $model = new Esp();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Esp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->checkAuth();

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Esp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->checkAuth();

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Esp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Esp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $this->checkAuth();

        if (($model = Esp::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionImport()
    {
        $this->checkAuth();

        $dir_files = array_diff(scandir('uploads/'), ['.', '..']);
        $messages = [];
        foreach ($dir_files as $xmllink) {
            $file = file_get_contents('uploads/' . $xmllink);
            try {
                $xml = simplexml_load_string($file);
                $json = json_encode($xml);
                $array = json_decode($json, TRUE);

                if (isset($array['Документ']['СвДокПТПрКроме']['СвДокПТПр']['СодФХЖ1']['ГрузПолуч']['ИдСв']['СвОрг']['СвЮЛ']['@attributes']['ИННЮЛ']) && !empty($array['Документ']['СвДокПТПрКроме']['СвДокПТПр']['СодФХЖ1']['ГрузПолуч']['ИдСв']['СвОрг']['СвЮЛ']['@attributes']['ИННЮЛ'])) {
                    $customer = $array['Документ']['СвДокПТПрКроме']['СвДокПТПр']['СодФХЖ1']['ГрузПолуч']['ИдСв']['СвОрг']['СвЮЛ']['@attributes']['ИННЮЛ'];
                    $address = $array['Документ']['СвДокПТПрКроме']['СвДокПТПр']['СодФХЖ1']['ГрузПолуч']['Адрес']['АдрИнф']['@attributes']['АдрТекст'];
                    $counter = 0;
                    if (isset($array['Документ']['СвДокПТПрКроме']['СодФХЖ2']['СвТов']['0'])) {
                        foreach ($array['Документ']['СвДокПТПрКроме']['СодФХЖ2']['СвТов'] as $value) {
                            $drink_name = $value['@attributes']['НаимТов'];
                            $count = $value['@attributes']['НеттоПередано'];
                            $model = $this->findModel((new Esp())->getId($customer, $address, $drink_name));

                            if (isset($model) && !empty($model)) {
                                $model->setlbase($count);
                                $model->setlbalance($count);
                                $model->esp_date_import = date("Y-m-d H:i:s");

                                if ($model->save()) {
                                    $counter += 1;
                                    $messages[] = [$address => $drink_name . ' = ' . $count];
                                }
                            }
                        }
                    } else {
                        $drink_name = $array['Документ']['СвДокПТПрКроме']['СодФХЖ2']['СвТов']['@attributes']['НаимТов'];
                        $count = $array['Документ']['СвДокПТПрКроме']['СодФХЖ2']['СвТов']['@attributes']['НеттоПередано'];
                        $model = $this->findModel((new Esp())->getId($customer, $address, $drink_name));

                        if (isset($model) && !empty($model)) {
                            $model->setlbase($count);
                            $model->setlbalance($count);
                            $model->esp_date_import = date("Y-m-d H:i:s");
                            if ($model->save()) {
                                $counter += 1;
                                $messages[] = [$address => $drink_name . ' = ' . $count];
                                $counter += 1;
                            }
                        }
                    }
                    if ($counter >= 1) {
                        unlink('uploads/' . $xmllink);
                    }
                }
                if (isset($array['Документ']['СвДокПТПрКроме']['СвДокПТПр']['СодФХЖ1']['ГрузПолуч']['ИдСв']['СвИП']['@attributes']['ИННФЛ']) && !empty($array['Документ']['СвДокПТПрКроме']['СвДокПТПр']['СодФХЖ1']['ГрузПолуч']['ИдСв']['СвИП']['@attributes']['ИННФЛ'])) {
                    $customer = $array['Документ']['СвДокПТПрКроме']['СвДокПТПр']['СодФХЖ1']['ГрузПолуч']['ИдСв']['СвИП']['@attributes']['ИННФЛ'];
                    $address = $array['Документ']['СвДокПТПрКроме']['СвДокПТПр']['СодФХЖ1']['ГрузПолуч']['Адрес']['АдрИнф']['@attributes']['АдрТекст'];
                    $counter = 0;
                    if (isset($array['Документ']['СвДокПТПрКроме']['СодФХЖ2']['СвТов']['0'])) {
                        foreach ($array['Документ']['СвДокПТПрКроме']['СодФХЖ2']['СвТов'] as $value) {
                            $drink_name = $value['@attributes']['НаимТов'];
                            $count = $value['@attributes']['НеттоПередано'];
                            $model = $this->findModel((new Esp())->getId($customer, $address, $drink_name));

                            if (isset($model) && !empty($model)) {
                                $model->setlbase($count);
                                $model->setlbalance($count);
                                $model->esp_date_import = date("Y-m-d H:i:s");
                                if ($model->save()) {
                                    $counter += 1;
                                    $messages[] = [$address => $drink_name . ' = ' . $count];
                                }
                            }
                        }
                    } else {
                        $drink_name = $array['Документ']['СвДокПТПрКроме']['СодФХЖ2']['СвТов']['@attributes']['НаимТов'];
                        $count = $array['Документ']['СвДокПТПрКроме']['СодФХЖ2']['СвТов']['@attributes']['НеттоПередано'];
                        $model = $this->findModel((new Esp())->getId($customer, $address, $drink_name));

                        if (isset($model) && !empty($model)) {
                            $model->setlbase($count);
                            $model->setlbalance($count);
                            $model->esp_date_import = date("Y-m-d H:i:s");
                            if ($model->save()) {
                                $counter += 1;
                                $messages[] = [$address => $drink_name . ' = ' . $count];
                                $counter += 1;
                            }
                        }
                    }
                    if ($counter >= 1) {
                        unlink('uploads/' . $xmllink);
                    }

                }


            } catch (Exception $e) {
                if (file_exists('uploads/' . $xmllink))
                    unlink('uploads/' . $xmllink);
            }
        }

        return $this->render('import', ['messages' => $messages]);
    }

    public function checkAuth()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
    }

    public function actionSettimeexp($id = null)
    {
        if (isset($id) && !empty($id)) {
            $esp_model = $this->findModel($id);

            $current_time = date("Y-m-d H:i:s");
            $hour_to_exp = $esp_model->attributes['hour_to_exp'];
            $current_time_exp = date("Y-m-d H:i:s", strtotime('+' . $hour_to_exp . ' hours'));

            $esp_model->setAttribute('data_set_storage', date("Y-m-d H:i:s"));
            $esp_model->setAttribute('data_exp_storage', $current_time_exp);
            $esp_model->setAttribute('timer_set', 1);
            if ($esp_model->save() === false && !$esp_model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }

            return $this->redirect(['esp/' . $id]);
        }
            return $this->redirect(['esp/'. $id]);
    }

}
