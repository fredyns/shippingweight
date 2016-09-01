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

            $isAdmin = FALSE;

            if (Yii::$app->user->isGuest == FALSE)
            {
                $isAdmin = Yii::$app->user->identity->isAdmin;
            }

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items'   => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    [
                        'label'   => 'Shipper',
                        'url'     => ['/shipper'],
                        'visible' => (Yii::$app->user->isGuest == FALSE),
                    ],
                    [
                        'label'   => 'Container',
                        'url'     => ['/container'],
                        'visible' => (Yii::$app->user->isGuest == FALSE),
                    ],
                    [
                        'label'   => 'Weighing',
                        'url'     => ['/weighing'],
                        'visible' => $isAdmin,
                    ],
                    [
                        'label'   => 'Transfer',
                        'url'     => ['/transfer'],
                        'visible' => $isAdmin,
                    ],
                    [
                        'label'   => 'Daily Report',
                        'url'     => ['/report-daily'],
                        'visible' => $isAdmin,
                    ],
                    [
                        'label' => 'Legal',
                        'url'   => '#',
                        'items' => [
                            ['label' => 'Kesepakatan Bersama VGM', 'url' => ['/content/kesepakatan-bersama-vgm-semarang.pdf']],
                        ],
                    ],
                    ['label' => 'About', 'url' => ['/site/about']],
                ],
            ]);

            if (Yii::$app->user->isGuest)
            {
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items'   => [
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
                <p>
                    Biro Klasifikasi Indonesia cabang Semarang
                    <br/>
                    <span style="font-size: 0.9em;">
                        Jl. Pamularsih No. 12 Semarang
                        (samping SD Al-Azhar)
                        Telp. 024-7610744
                    </span>
                </p>

                <!--
                <p class="pull-right"><?= Yii::powered() ?></p>
                -->

            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
