<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => 'BKI VGM',
                'brandUrl'   => Yii::$app->homeUrl,
                'options'    => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            if (Yii::$app->user->isGuest)
            {
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items'   => [
                        ['label' => 'Home', 'url' => ['/site/index']],
                        ['label' => 'About', 'url' => ['/site/about']],
                        //['label' => 'Contact', 'url' => ['/site/contact']],
                        ['label' => 'Login', 'url' => ['/user/security/login']],
                        ['label' => 'Register', 'url' => ['/user/registration/register']],
                    ],
                ]);
            }
            else
            {
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items'   => [
                        ['label' => 'Home', 'url' => ['/site/index']],
                        ['label' => 'About', 'url' => ['/site/about']],
                        //['label' => 'Contact', 'url' => ['/site/contact']],
                        ['label' => 'My Profile', 'url' => ['/user/settings/profile']],
                        '<li>'
                        .Html::beginForm(['/user/security/logout'], 'post', ['class' => 'navbar-form'])
                        .Html::submitButton(
                            'Logout', ['class' => 'btn btn-link']
                        )
                        .Html::endForm()
                        .'</li>'
                    ],
                ]);
            }

            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; Badan Klasifikasi Indonesia <?= date('Y') ?></p>

                <!--
                <p class="pull-right"><?= Yii::powered() ?></p>
                -->

            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
