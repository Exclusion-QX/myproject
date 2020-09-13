<?php

/* @var $this yii\web\View */
/* @var $currentUser [] frontend\models\User */

/* @var $feedItems [] frontend\models\Feed */

use yii\web\JqueryAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;

$this->title = 'Newsfeed';
?>

    <div class="page-posts no-padding">
        <div class="row">
            <div class="page page-post col-sm-12 col-xs-12">
                <div class="blog-posts blog-posts-large">
                    <div class="row">

                        <?php if ($feedItems): ?>
                            <?php foreach ($feedItems as $feedItem): ?>
                                <?php /* @var $feedItem Feed */ ?>

                                <!-- feed item -->
                                <article class="post col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2">
                                            <div class="post-meta">
                                                <div class="post-title">
                                                    <img src="/uploads/<?php echo $currentUser->getUserById($feedItem->author_id)->picture; ?>"
                                                         class="author-image"/>
                                                    <div class="author-name">
                                                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($currentUser->getUserById($feedItem->author_id)->nickname) ? $currentUser->getUserById($feedItem->author_id)->nickname : $feedItem->author_id]); ?>">
                                                            <?php echo Html::encode($currentUser->getUserById($feedItem->author_id)->username); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="post-type-image">
                                                <a href="<?php echo Url::to(['/post/default/view', 'id' => $feedItem->post_id]); ?>">
                                                    <img src="<?php echo Yii::$app->storage->getFile($feedItem->post_filename); ?>">
                                                </a>
                                            </div>
                                            <div class="post-description">
                                                <p><?php echo HtmlPurifier::process($feedItem->post_description); ?></p>
                                            </div>
                                            <div class="post-bottom">
                                                <div class="post-likes">
                                                    <span class="likes-count"><?php echo $feedItem->countLikes(); ?></span>
                                                    &nbsp;
                                                    <a href="#"
                                                       class="btn btn-default button-heart button-unlike <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "" : "display-none"; ?>"
                                                       data-id="<?php echo $feedItem->post_id; ?>">

                                                        <i class="fa fa-2x fa-heart heart-ani" style="color: #FB000D;"></i>
                                                    </a>

                                                    <a href="#"
                                                       class="btn btn-default button-heart  button-like <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "display-none" : ""; ?>"
                                                       data-id="<?php echo $feedItem->post_id; ?>">
                                                        <i class="fa fa-2x fa-heart-o heart-ani"></i>
                                                    </a>
                                                </div>
                                                <div class="post-comments">
                                                    <a href="<?php echo Url::to(['/post/default/view', 'id' => $feedItem->post_id]); ?>"><?php echo Yii::t('feed', 'Comments') ?>: <?php echo $feedItem->countComments(); ?></a>

                                                </div>
                                                <div class="post-date">
                                                    <span><?php echo Yii::$app->formatter->asRelativeTime($feedItem->post_created_at); ?></span>
                                                </div>
                                                <div class="post-report">
                                                    <?php if (!$feedItem->isReported($currentUser)): ?>
                                                        <a href="#" class="btn btn-default button-complain" data-id="<?php echo $feedItem->post_id; ?>">
                                                            <?php echo Yii::t('feed', 'Report post') ?> <i class="fa fa-cog fa-spin fa-fw icon-preloader" style="display: none"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <p><?php echo Yii::t('feed', 'Post has been reported') ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <!-- feed item -->
                            <?php endforeach; ?>

                        <?php else: ?>

                            <div class="col-md-12" style="text-align: center">
                                <h2>Nobody posted yet!</h2>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]);
$this->registerJsFile('@web/js/complaints.js', [
    'depends' => JqueryAsset::className(),
]);




