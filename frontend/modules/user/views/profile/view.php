<?php
/* @var $this yii\web\View */
/* @var $user frontend\models\User */
/* @var $currentUser frontend\models\User */

/* @var $modelPicture frontend\modules\user\models\forms\PictureForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use dosamigos\fileupload\FileUpload;

$this->title = Html::encode($user->username);
?>

<div class="page-posts no-padding">
    <div class="row">
        <div class="page page-post col-sm-12 col-xs-12 post-82">


            <div class="blog-posts blog-posts-large">

                <div class="row">

                    <!-- profile -->
                    <article class="profile col-sm-12 col-xs-12">
                        <div class="profile-title">
                            <img src="<?php echo $user->getPicture(); ?>" id="profile-picture" class="author-image" />

                            <div class="author-name"><?php echo Html::encode($user->username); ?></div>

                            <?php if ($currentUser && $currentUser->equals($user)): ?>

                                <hr>

                                <?= FileUpload::widget([
                                    'model' => $modelPicture,
                                    'attribute' => 'picture',
                                    'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
                                    'options' => ['accept' => 'image/*'],
                                    'clientEvents' => [
                                        'fileuploaddone' => 'function(e, data) {
                if (data.result.success) {
                    $("#profile-image-success").show();
                    $("#profile-image-fail").hide();
                    $("#profile-picture").attr("src", data.result.pictureUri);
                } else {
                    $("#profile-image-fail").html(data.result.errors.picture).show();
                    $("#profile-image-success").hide();
                }
            }',

                                    ],
                                ]); ?>
                                <a href="<?php echo Url::to(['/user/profile/delete-picture']); ?>"
                                   class="btn btn-danger"><?php echo Yii::t('profile', 'Delete picture') ?></a>

                                <a href="#" data-toggle="modal" data-target="#editProfileModal" class="btn btn-default"><?php echo Yii::t('profile', 'Edit profile') ?></a>
                            <?php endif; ?>

<!--                            <a href="#" class="btn btn-default">Upload profile image</a>-->


                            <br>
                            <br>
                            <div class="alert alert-success display-none" id="profile-image-success">
                                <?php echo Yii::t('profile', 'Profile image updated') ?>
                            </div>
                            <div class="alert alert-danger display-none" id="profile-image-fail"></div>

                        </div>

                        <?php if ($currentUser && !$currentUser->equals($user)): ?>

                            <a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]); ?>"
                               class="btn btn-info <?php echo ($currentUser && $user->isSubscribeBy($currentUser)) ? "display-none" : ""; ?>">
                                <?php echo Yii::t('profile', 'Subscribe') ?></a>
                            <a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]); ?>"
                               class="btn btn-default <?php echo ($currentUser && $user->isSubscribeBy($currentUser)) ? "" : "display-none"; ?>">
                                <?php echo Yii::t('profile', 'Unsubscribe') ?>
                            </a>
                            <hr>
                            <h5><?php echo Yii::t('profile', 'Friends, who are also following') ?><?php echo Html::encode($user->username); ?>: </h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php foreach ($currentUser->getMutualSubscriptionsTo($user) as $item): ?>
                                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($item['nickname']) ? $item['nickname'] : $item['id']]); ?>">
                                            <?php echo Html::encode($item['username']); ?>
                                        </a>
                                        &nbsp;&nbsp;
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <hr>
                        <?php endif; ?>

                        <?php if ($user->about): ?>
                            <div class="profile-description">
                                <p><?php echo HtmlPurifier::process($user->about); ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="profile-bottom">
                            <div class="profile-post-count">
                                <span><?php echo Yii::t('profile', 'Posts') ?> <?php echo $user->getPostCount(); ?></span>
                            </div>
                            <div class="profile-followers">
                                <a href="#" data-toggle="modal" data-target="#myModalFollowers">
                                    <?php echo Yii::t('profile', 'Followers') ?> <?php echo $user->countFollowers(); ?>
                                </a>
                            </div>
                            <div class="profile-following">
                                <a href="#" data-toggle="modal" data-target="#myModalSubscribes">
                                    <?php echo Yii::t('profile', 'Following') ?> <?php echo $user->countSubscriptions(); ?>
                                </a>
                            </div>
                        </div>
                    </article>

                    <div class="col-sm-12 col-xs-12">
                        <div class="row profile-posts">
                            <?php foreach ($user->getPosts() as $post): ?>
                                <div class="col-md-4 profile-post">
                                    <a href="<?php echo Url::to(['/post/default/view', 'id' => $post->getId()]); ?>">
                                        <img src="<?php echo Yii::$app->storage->getFile($post->filename); ?>" class="author-image" />
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                </div>

            </div>
        </div>

    </div>
</div>


<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="myModalSubscribes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><? echo Yii::t('profile', 'Subscribes') ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($user->getSubscriptions() as $subscription): ?>
                        <div class="col-md-12">
                            <div class="modal-window">
                                <img src="/uploads/<?php echo $subscription['picture']; ?>" class="author-image">
                                <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($subscription['nickname']) ? $subscription['nickname'] : $subscription['id']]); ?>">
                                    <?php echo Html::encode($subscription['username']); ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><? echo Yii::t('profile', 'Close') ?></button>
<!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModalFollowers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><? echo Yii::t('profile', 'Followers') ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($user->getFollowers() as $follower): ?>
                        <div class="col-md-12">
                            <div class="modal-window">
                                <img src="/uploads/<?php echo $follower['picture']; ?>" class="author-image">
                                <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($follower['nickname']) ? $follower['nickname'] : $follower['id']]); ?>">
                                    <?php echo Html::encode($follower['username']); ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><? echo Yii::t('profile', 'Close') ?></button>
<!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><? echo Yii::t('profile', 'Edit profile') ?></h4>
            </div>
            <?php $form = ActiveForm::begin([
                'action' => ['profile/edit', 'id' => $currentUser->id],
            ]); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <?php echo $form->field($model, 'username')->textInput(['value' => $currentUser->username])->label(Yii::t('profile' , 'Username')); ?>

                        <?php echo $form->field($model, 'nickname')->label(Yii::t('profile' , 'Nickname')); ?>

                        <?php echo $form->field($model, 'about')->textarea(['style' => 'resize: none;'])->label(Yii::t('profile' , 'About')); ?>

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