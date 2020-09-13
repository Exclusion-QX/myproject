<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\FontAwesomeAsset;
use common\widgets\Alert;
use yii\widgets\ActiveForm;

AppAsset::register($this);
FontAwesomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>

<body class="home page">

<div class="wrapper">
    <header>
        <div class="header-top">
            <div class="container">
                <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4 brand-logo">
                    <h1>
                        <a href="<?php echo Url::to(['/site/index']); ?>">
                            <img src="/img/imagex2.png" alt="">
                        </a>
                    </h1>
                </div>
                <div class="col-md-4 col-sm-4 navicons-topbar">
                    <ul>
                        <li class="blog-search">
                            <a href="#" title="Search" data-toggle="modal" data-target="#myModalSearch">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                        <li>
                            <?= Html::beginForm(['/site/language']) ?>
                            <?= Html::dropDownList('language', Yii::$app->language, ['en-US' => 'English', 'ru-RU' => 'Русский'], ['class' => 'form-control input-sm']) ?>
                        </li>
                        <li>
                            <?= Html::submitButton(Yii::t('menu', 'Change'), ['class' => 'btn btn-sm btn-default']) ?>
                            <?= Html::endForm() ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="header-main-nav">
            <div class="container">
                <div class="main-nav-wrapper" style="z-index: 999;">
<!--                    <nav class="main-menu">-->
<!--                        --><?php
//
//                        if (Yii::$app->user->isGuest) {
//                            $menuItems[] = ['label' => Yii::t('menu', 'Signup'), 'url' => ['/user/default/signup']];
//                            $menuItems[] = ['label' => Yii::t('menu', 'Login'), 'url' => ['/user/default/login']];
//                        } else {
//                            $menuItems = [
//                                ['label' => Yii::t('menu', 'Newsfeed'), 'url' => ['/site/index']],
//                            ];
//                            $menuItems[] = ['label' => Yii::t('menu', 'My profile'), 'url' => ['/user/profile/view', 'nickname' => Yii::$app->user->identity->getNickname()]];
//                            $menuItems[] = ['label' => Yii::t('menu', 'Create post'), 'url' => ['/post/default/create']];
//
//                            $menuItems[] = '<li>'
//                                . Html::beginForm(['/user/default/logout'], 'post')
//                                . Html::submitButton(
//                                    Yii::t('menu' , 'Logout ({username})', [
//                                            'username' => Yii::$app->user->identity->username
//                                    ]).'<i class="fa fa-sign-out"></i>', ['class' => 'btn btn-link logout']
//                                )
//                                . Html::endForm()
//                                . '</li>';
//                        }
//                        echo Nav::widget([
//                            'options' => ['class' => 'menu navbar-nav navbar-right'],
//                            'items' => $menuItems,
//                        ]);
//                        ?>
<!--                    </nav>-->
                    <nav class="navbar navbar-default main-menu">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"">
                            <?php

                            if (Yii::$app->user->isGuest) {
                                $menuItems[] = ['label' => Yii::t('menu', 'Signup'), 'url' => ['/user/default/signup']];
                                $menuItems[] = ['label' => Yii::t('menu', 'Login'), 'url' => ['/user/default/login']];
                            } else {
                                $menuItems = [
                                    ['label' => Yii::t('menu', 'Newsfeed'), 'url' => ['/site/index']],
                                ];
                                $menuItems[] = ['label' => Yii::t('menu', 'My profile'), 'url' => ['/user/profile/view', 'nickname' => Yii::$app->user->identity->getNickname()]];
                                $menuItems[] = ['label' => Yii::t('menu', 'Create post'), 'url' => ['/post/default/create']];

                                $menuItems[] = '<li class="logout-button">'
                                    . Html::beginForm(['/user/default/logout'], 'post')
                                    . Html::submitButton(
                                        Yii::t('menu' , 'Logout ({username})', [
                                            'username' => Yii::$app->user->identity->username
                                        ]).'<i class="fa fa-sign-out"></i>', ['class' => 'btn btn-link logout']
                                    )
                                    . Html::endForm()
                                    . '</li>';
                            }
                            echo Nav::widget([
                                'options' => ['class' => 'menu navbar-nav navbar-right'],
                                'items' => $menuItems,
                            ]);
                            ?>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                </div>
            </div>
        </div>



    </header>


    <div class="container full">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <div class="push"></div>
</div>

<?php $this->registerJsFile('@web/js/search.js', [
    'depends' => \yii\web\JqueryAsset::className(),
]); ?>

<footer>
    <div class="footer">
        <div class="back-to-top-page">
            <a class="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        </div>
        <p class="text">Imagex | 2020</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


<?php
//    NavBar::begin([
//        'brandLabel' => Yii::$app->name,
//        'brandUrl' => Yii::$app->homeUrl,
//        'options' => [
//            'class' => 'navbar-inverse navbar-fixed-top',
//        ],
//    ]);

//    NavBar::end();
?>

<!-- Modal -->
<div class="modal fade" id="myModalSearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><? echo Yii::t('menu', 'Search') ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12">

                        <form>
                            <!-- Поле поиска -->
                            <div class="col-md-8 col-md-offset-2">
                                <div class="modal-window">
                                    <input type="text" id="search" class="form-control" placeholder="Поиск людей">
                                </div>
                            </div>
                        </form>


                        <div id="search-panel">

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><? echo Yii::t('profile', 'Close') ?></button>
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>

</div>

