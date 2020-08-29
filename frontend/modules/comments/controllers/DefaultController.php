<?php

namespace frontend\modules\comments\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use frontend\modules\comments\models\forms\CommentForm;

class DefaultController extends Controller
{

    public function actionSend()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        $model = new CommentForm(Yii::$app->user->identity);

        if ($model->load(Yii::$app->request->post())) {

//            $model->picture = UploadedFile::getInstance($model, 'picture');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Post created!');
                return $this->goHome();
            }
        }
        return $this->render('send', [
            'model' => $model,
        ]);
    }


}