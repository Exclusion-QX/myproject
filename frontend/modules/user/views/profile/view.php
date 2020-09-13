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
                            <div class="col-md-4">
                            <img src="<?php echo $user->getPicture(); ?>" id="profile-picture" class="author-image" />

                            <div class="author-name"><?php echo Html::encode($user->username); ?></div>
                            </div>
                            <div class="col-md-5 col-sm-6 col-xs-7 col-sm-offset-1 profile-info">
                                <div class="profile-bottom">
                                    <div class="profile-post-count">
                                        <span><?php echo Yii::t('profile', 'Posts') ?>
                                            <strong><?php echo $user->getPostCount(); ?></strong></span>
                                    </div>
                                    <div class="profile-followers">
                                        <a href="#" data-toggle="modal" data-target="#myModalFollowers">
                                            <?php echo Yii::t('profile', 'Followers') ?>
                                            <strong><?php echo $user->countFollowers(); ?></strong>
                                        </a>
                                    </div>
                                    <div class="profile-following">
                                        <a href="#" data-toggle="modal" data-target="#myModalSubscribes">
                                            <?php echo Yii::t('profile', 'Following') ?>
                                            <strong><?php echo $user->countSubscriptions(); ?></strong>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php if ($currentUser && $currentUser->equals($user)): ?>
                                <div class="col-md-2 col-sm-4 col-xs-4 profile-button">
                                    <a href="#" data-toggle="modal" data-target="#editProfileModal"
                                       class="btn btn-default"><?php echo Yii::t('profile', 'Edit profile') ?></a>
                                </div>
                            <?php endif; ?>


<!--                            <a href="#" class="btn btn-default">Upload profile image</a>-->

                            <div class="alert alert-success display-none" id="profile-image-success">
                                <?php echo Yii::t('profile', 'Profile image updated') ?>
                            </div>
                            <div class="alert alert-danger display-none" id="profile-image-fail"></div>


                            <?php if ($currentUser && !$currentUser->equals($user)): ?>

                            <div class="col-md-2 col-xs-3 profile-button">
                                <a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]); ?>"
                                   class="btn btn-info <?php echo ($currentUser && $user->isSubscribeBy($currentUser)) ? "display-none" : ""; ?>">
                                    <?php echo Yii::t('profile', 'Subscribe') ?></a>
                                <a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]); ?>"
                                   class="btn btn-default <?php echo ($currentUser && $user->isSubscribeBy($currentUser)) ? "" : "display-none"; ?>">
                                    <?php echo Yii::t('profile', 'Unsubscribe') ?>
                                </a>
                            </div>
                        </div>


                        <?php if ($currentUser->getMutualSubscriptionsTo($user)): ?>
                            <div class="row profile-mutual-subscriptions">
                                <div class="col-md-7 col-md-offset-1 col-sm-7 col-sm-offset-1 col-xs-7 col-xs-offset-1">
                                    <span><?php echo Yii::t('profile', 'Followed by') ?>&nbsp;</span>

                                    <?php foreach ($currentUser->getMutualSubscriptionsTo($user) as $item): ?>
                                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($item['nickname']) ? $item['nickname'] : $item['id']]); ?>">
                                            <?php echo Html::encode($item['username']); ?>
                                        </a>
                                        &nbsp;
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        <?php endif; ?>


                        <?php endif; ?>

                        <?php if ($user->about): ?>
                            <div class="profile-description col-md-12 col-xs-12">
                                <p><?php echo HtmlPurifier::process($user->about); ?></p>
                            </div>
                        <?php endif; ?>
<!--                        <div class="profile-bottom">-->
<!--                            <div class="profile-post-count">-->
<!--                                <span>--><?php //echo Yii::t('profile', 'Posts') ?><!-- --><?php //echo $user->getPostCount(); ?><!--</span>-->
<!--                            </div>-->
<!--                            <div class="profile-followers">-->
<!--                                <a href="#" data-toggle="modal" data-target="#myModalFollowers">-->
<!--                                    --><?php //echo Yii::t('profile', 'Followers') ?><!-- --><?php //echo $user->countFollowers(); ?>
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="profile-following">-->
<!--                                <a href="#" data-toggle="modal" data-target="#myModalSubscribes">-->
<!--                                    --><?php //echo Yii::t('profile', 'Following') ?><!-- --><?php //echo $user->countSubscriptions(); ?>
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
                    </article>

                    <div class="col-sm-12 col-xs-12">
                        <div class="row">
                            <?php foreach ($user->getPosts() as $post): ?>
                                <div class="col-md-4 col-sm-6 col-xs-6 profile-post" style="background-size: cover;">
                                    <a href="<?php echo Url::to(['/post/default/view', 'id' => $post->getId()]); ?>">
                                        <div class="body-post-image">
                                            <img src="<?php echo Yii::$app->storage->getFile($post->filename); ?>"
                                                 class="post-image"/>
                                        </div>
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

                        <?php echo $form->field($model, 'nickname')->textInput(['value' => $currentUser->nickname])->label(Yii::t('profile' , 'Nickname')); ?>

                        <?php echo $form->field($model, 'about')->textarea(['value' => $currentUser->about, 'style' => 'resize: none;'])->label(Yii::t('profile' , 'About')); ?>

                        <label><?php echo Yii::t('profile', 'Picture') ?></label>
                        <br>

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