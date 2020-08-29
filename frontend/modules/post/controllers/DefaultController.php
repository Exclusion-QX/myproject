<?php

namespace frontend\modules\post\controllers;


use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use frontend\models\Post;
use frontend\modules\post\models\forms\PostForm;
use frontend\modules\post\models\forms\CommentForm;
use frontend\modules\post\models\forms\EditForm;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{

    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        $model = new PostForm(Yii::$app->user->identity);
        if ($model->load(Yii::$app->request->post())) {

            $model->picture = UploadedFile::getInstance($model, 'picture');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Post created!');
                return $this->goHome();
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Renders the create view for the module
     * @return string
     */
    public function actionView($id)
    {
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);
        $newComment = new CommentForm();
        $comment = $post->getComments();
        $model = new EditForm();

        /* @var $currentUser User */
        return $this->render('view', [
            'post' => $post,
            'currentUser' => $currentUser,
            'newComment' => $newComment,
            'comment' => $comment,
            'model' => $model,
        ]);
    }

    public function actionComment($id, $username)
    {
        $model = new CommentForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save($id, $username)) {
                Yii::$app->session->setFlash('success', 'Comment sent!');
                return $this->redirect(['/post/default/view', 'id' => $id]);
            }
        }
    }

    public function actionLike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $post = $this->findPost($id);

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $post->like($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];
    }

    public function actionUnlike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);

        $post->unLike($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];
    }

    public function actionComplain()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);

        if ($post->complain($currentUser)) {
            return [
                'success' => true,
                'text' => 'Post reported'
            ];
        }
        return [
            'success' => false,
            'text' => 'Error',
        ];
    }

    /**
     * @param integer $id
     * @return User
     * @throws NotFoundHttpException
     */
    private function findPost($id)
    {
        if ($user = Post::findOne($id)) {
            return $user;
        }
        throw new NotFoundHttpException();
    }

    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDeletecomment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $post = new Post();
        $comment = $post->getCommentById($id);
        $author = $post->getUserPost($comment['post_id']);

        if (($author['user_id'] == Yii::$app->user->id) || ($comment['user_id'] == Yii::$app->user->id)) {
            $post->deleteComment($id);

            return [
                'success' => true,
            ];
        }

        return [
            'success' => false,
        ];
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');

        $this->findModel($id)->deleteFeeds();
        $this->findModel($id)->deleteLikes();
        $this->findModel($id)->delete();

        return $this->redirect(['/user/profile/view', 'nickname' => Yii::$app->user->id]);
    }

    public function actionEdit($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        $model = new EditForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save($id)) {
                Yii::$app->session->setFlash('success', 'Change saved');
                return $this->redirect(['/post/default/view', 'id' => $id]);
            }
        }

    }

}
