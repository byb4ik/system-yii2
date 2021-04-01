<?php

namespace app\controllers;


use app\models\Login;
use app\models\Users;
use app\models\Esp;
use app\models\EspSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;


class SiteController extends Controller
{

    public function actionIndex()
    {
        $mod = new Esp();

        if (!Yii::$app->user->isGuest) {
            $this->redirect(['index']);
        }
        return $this->redirect(['login']);
    }

    public function actionLogout()
    {

        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->redirect(['login']);
        }

    }


    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/esp']);
        }

        $login_model = new Login();

        if (Yii::$app->request->post('Login')) {

            $login_model->attributes = Yii::$app->request->post('Login');
            if ($login_model->validate()) {
                Yii::$app->user->login($login_model->findByEmail(), 3600*24*7);

                return $this->redirect(['/esp']);
            }
        }

        return $this->render('login', ['login_model' => $login_model]);

    }

}
