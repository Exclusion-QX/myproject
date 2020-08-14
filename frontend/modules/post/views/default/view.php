<?php
/* @var $this yii\web\View */

/* @var $post frontend\models\Post */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>
    <div class="post-default-index">

        <div class="row">

            <div class="col-md-12">
                <article class="profile">
                    <div class="profile-title">
                        <img src="<?php echo $post->user->getPicture(); ?>" id="profile-picture" class="author-image"/>

                        <div class="author-name">
                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($post->user->id) ? $post->user->id : $post->user->id]); ?>">
                            <?php if ($post->user): ?>
                                <?php echo Html::encode($post->user->username); ?>
                            <?php endif; ?>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-md-12">
                <?php echo Html::encode(Yii::$app->formatter->asDatetime($post->created_at)); ?>
            </div>

            <div class="col-md-8">
                <a href="#" data-toggle="modal" data-target="#myModalFunctions">
                    <i class="fa fa-lg fa-align-justify pull-right" style="margin-bottom: 10px;"></i>
                </a>
                <img src="<?php echo $post->getImage(); ?>" />
            </div>

            <div class="col-md-12 post-description-padding">
                <?php echo Html::encode($post->description); ?>
            </div>

        </div>



        <div class="col-md-8">
            <hr>
            Likes: <span class="likes-count"><?php echo $post->countLikes(); ?></span>

            <a href="#"
               class="btn btn-primary button-like <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "display-none" : ""; ?>"
               data-id="<?php echo $post->id; ?>">
                Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
            </a>

            <a href="#"
               class="btn btn-primary button-unlike <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "" : "display-none"; ?>"
               data-id="<?php echo $post->id; ?>">
                Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
            </a>
        </div>

        <?php if (!Yii::$app->user->isGuest): ?>

            <div class="col-md-8">
                <h4><?php echo Yii::t('post', 'Leave a reply') ?></h4>
            </div>

            <div class="comment-form col-md-8">

                <?php $form = ActiveForm::begin([
                    'action' => ['default/comment', 'id' => $post->id, 'username' => $currentUser->username],
                ]); ?>

                <?php echo $form->field($newComment, 'comment')->textarea(['class' => 'form-control', 'style' => 'resize: none;' , 'placeholder' => Yii::t('post', 'Write comment')])->label(false); ?>

                <?php echo Html::submitButton(Yii::t('post', 'Send'), ['class' => 'btn btn-default']); ?>

                <?php ActiveForm::end(); ?>

                <hr>
            </div>

        <?php endif; ?>

        <?php foreach ($comment as $commentItem): ?>
            <?php /* @var $commentItem Post */ ?>

            <!-- comment item -->
            <div class="col-md-8" id="comment" data-id="<?php echo $commentItem->id; ?>">
                <article class="comment col-sm-12 col-xs-12">
                    <div class="profile-title">
                        <img src="/uploads/<?php echo $currentUser->getUserById($commentItem->user_id)->picture; ?>"
                             class="author-image"/>
                        <div class="author-name">
                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($commentItem->user_id) ? $commentItem->user_id : $commentItem->user_id]); ?>">
                                <?php echo Html::encode($currentUser->getUserById($commentItem->user_id)->username); ?>
                            </a>
                        </div>
                        <div class="comment-description">
                            <p><?php echo Html::encode($commentItem->comment); ?></p>
                        </div>
                        <div class="comment-date">
                            <p><?php echo Html::encode(Yii::$app->formatter->asDatetime($commentItem->created_at)); ?></p>
                        </div>
                        <?php if ((Yii::$app->user->id == $post->user->id)||(Yii::$app->user->id == $commentItem->user_id)): ?>
                            <div class="delete-comment">
                                <a href="#" class="comment-delete" data-id="<?php echo $commentItem->id; ?>"><?php echo Yii::t('post', 'Delete') ?></a>
                            </div>
                        <?php else: ?>
                            <div class="answer-comment">
                                <a href="#" class="comment-answer"><?php echo Yii::t('post', 'Answer') ?></a>
                            </div>
                        <?php endif; ?>
                        <hr>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModalFunctions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <?php if (Yii::$app->user->id == $post->user->id): ?>
                                <div class="modal-window">
                                    <a href="#" data-toggle="modal" data-target="#myModalEdit" data-dismiss="modal">Редактировать</a>
                                </div>
                                <hr>
                            <?php endif; ?>
                            <?php if (Yii::$app->user->id == $post->user->id): ?>
                                <div class="modal-window">
                                    <a href="#" class="post-delete" data-id="<?php echo $post->id; ?>">Удалить</a>
                                </div>
                                <hr>
                            <?php endif; ?>
                            <div class="modal-window">
                                <?php if (!$post->isReported($currentUser)): ?>
                                    <a href="#" class="button-complain" data-id="<?php echo $post->id; ?>">Пожаловаться</a>
                                <?php else: ?>
                                    <p><?php echo Yii::t('profile', 'Post has been reported') ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php $form = ActiveForm::begin([
                    'action' => ['default/edit', 'id' => $post->id],
                ]); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $form->field($model, 'description')->textarea(['style' => 'resize: none;', 'value' => $post->description])->label(Yii::t('post', 'Description')); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><? echo Yii::t('profile', 'Close') ?></button>
                    <?php echo Html::submitButton(Yii::t('profile', 'Save changes'), ['class' => 'btn btn-primary']);?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php $this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]);
$this->registerJsFile('@web/js/comments.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]);
$this->registerJsFile('@web/js/complaints.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]);
$this->registerJsFile('@web/js/profile.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]);