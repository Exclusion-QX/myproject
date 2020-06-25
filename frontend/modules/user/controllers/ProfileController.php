<?php

namespace frontend\modules\user\controllers;

use frontend\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `user` module
 */
class ProfileController extends Controller
{

    public function actionView($id)
    {
        return $this->render('view', [
            'user' => $this->findUser($id),
        ]);
    }

    public function findUser($id)
    {
        if ($user = User::find()->where(['id' => $id])->one()) {
            return $user;
        }
        throw new NotFoundHttpException();
    }
}
