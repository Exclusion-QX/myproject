<?php
/* @var $this yii\web\View */

/* @var $model frontend\modules\post\models\forms\PostForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="post-default-index">

    <div class="row">

        <div class="col-md-6 col-md-offset-3">

            <h1 class="text-center"><?php echo Yii::t('menu', 'Create post')?></h1>

            <?php $form = ActiveForm::begin(); ?>

            <?php echo $form->field($model, 'picture')->fileInput()->label(Yii::t('menu', 'Picture')); ?>

            <?php echo $form->field($model, 'description')->label(Yii::t('menu', 'Description')); ?>

            <?php echo Html::submitButton(Yii::t('menu', 'Create')); ?>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div>
