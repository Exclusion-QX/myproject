<?php
/* @var $this yii\web\View */
/* @var $post frontend\models\Post */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="post-default-index">

    <div class="row">

        <div class="col-md-12">
            <article class="profile">
                <div class="profile-title">
                    <img src="<?php echo $post->user->getPicture(); ?>" id="profile-picture" class="author-image"/>
                    <div class="author-name">
                        <?php if ($post->user): ?>
                            <?php echo $post->user->username; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        </div>

        <div class="col-md-12">
            <?php echo Html::encode(Yii::$app->formatter->asDatetime($post->created_at)); ?>
        </div>

        <div class="col-md-12">
            <img src="<?php echo $post->getImage(); ?>" style="width: 800px;" />
        </div>

        <div class="col-md-12 post-description-padding">
            <?php echo Html::encode($post->description); ?>
        </div>

    </div>

    <hr>

    <div class="col-md-12">
        Likes: <span class="likes-count"><?php echo $post->countLikes(); ?></span>

        <a href="#" class="btn btn-primary button-like <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "display-none" : ""; ?>" data-id="<?php echo $post->id; ?>">
            Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
        </a>

        <a href="#" class="btn btn-primary button-unlike <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "" : "display-none"; ?>" data-id="<?php echo $post->id; ?>">
            Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
        </a>

    </div>

<!--    <div class="col-md-12">-->
<!--        Comments-->
<!---->
<!--        --><?php //$form = ActiveForm::begin(); ?>
<!---->
<!--        --><?php //echo $form->field($model, 'description'); ?>
<!---->
<!--        --><?php //echo Html::submitButton('Send'); ?>
<!---->
<!--        --><?php //ActiveForm::end(); ?>
<!--    </div>-->
</div>
<?php $this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]);