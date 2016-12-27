<?php

namespace app\widget;

use Yii;
use yii\bootstrap\Html;
use app\models\Container;
use cornernote\returnurl\ReturnUrl;

/**
 * Description of ContainerMenu
 *
 * @author fredy
 */
class ContainerMenu extends \yii\jui\Widget
{
    public $options = [];

    /**
     *
     * @var Container
     */
    public $model;

    public function run()
    {
        // permit
        $admin = Yii::$app->user->identity->isAdmin;
        $owner = ($this->model->shipper->user_id == Yii::$app->user->id);
        $permit = ($admin OR $owner);

        /**
         * waktu baru daftar, belum bayar
         * tampilkan alert pembayaran
         */
        if ($this->model->status == Container::STATUS_REGISTERED) {
            if ($admin) {
                echo Html::a(
                    '<span class="glyphicon glyphicon-usd"></span> Payment',
                    [
                    '/container/payment',
                    'id' => $this->model->id,
                    'ru' => ReturnUrl::getToken(),
                    ],
                    [
                    'class' => 'btn btn-primary',
                    'target' => '_blank',
                    'data-pjax' => 0,
                    ]
                )
                .'&nbsp;';
            } else {
                echo '<span class="btn btn-warning" title="silahkan lakukan pembayaran di loket BKI">registered</span>&nbsp;';
            }
        }

        /**
         * waktu pendaftar/emkl sudah membayar
         * tampilkan tombol pengecekan berat
         */
        if ($this->model->status == Container::STATUS_READY) {
            if ($permit) {
                echo Html::a(
                    '<span class="glyphicon glyphicon-scale"></span> Check',
                    [
                    '/container/check',
                    'id' => $this->model->id,
                    'ru' => ReturnUrl::getToken(),
                    ],
                    [
                    'class' => 'btn btn-primary',
                    'data-pjax' => 0,
                    ]
                )
                .'&nbsp;';
            } else {
                echo '<span class="btn btn-info">ready</span>&nbsp;';
            }
        }

        /**
         * waktu container sudah ditimbang
         * tampilkan tombol print
         */
        if ($this->model->status == Container::STATUS_VERIFIED) {
            if ($permit) {
                echo Html::a(
                    '<span class="glyphicon glyphicon-print"></span> Print VGM',
                    [
                    '/certificate/pdf',
                    'id' => $this->model->id,
                    'container_number' => $this->model->number,
                    'ru' => ReturnUrl::getToken(),
                    ],
                    [
                    'class' => 'btn btn-success',
                    'title' => 'cetak sertifikat VGM',
                    'target' => '_blank',
                    'data-pjax' => 0,
                    ]
                )
                .'&nbsp;';

                if ($permit) {
                    echo Html::a(
                        '<span class="glyphicon glyphicon-scale"></span> Recheck',
                        [
                        '/container/check',
                        'id' => $this->model->id,
                        'ru' => ReturnUrl::getToken(),
                        ],
                        [
                        'class' => 'btn btn-primary',
                        'data-pjax' => 0,
                        ]
                    )
                    .'&nbsp;';
                }
                /* /
                  echo Html::a(
                  '<span class="glyphicon glyphicon-send"></span> Send VGM',
                  [
                  '/container/send',
                  'id' => $this->model->id,
                  ], [
                  'class' => 'btn btn-info',
                  'target'    => '_blank',
                  'data-pjax' => 0,
                  ]
                  )
                  .'&nbsp;';
                  // */
            } else {
                echo '<span class="btn btn-success">verified</span>&nbsp;';
            }
        }

        /**
         * ketika terjadi error
         */
        if ($this->model->status == Container::STATUS_ALERT) {
            echo '<span class="btn btn-danger">something wrong</span>&nbsp;';

            if ($permit) {
                echo Html::a(
                    '<span class="glyphicon glyphicon-scale"></span> Check',
                    [
                    '/container/check',
                    'id' => $this->model->id,
                    'ru' => ReturnUrl::getToken(),
                    ],
                    [
                    'class' => 'btn btn-primary',
                    'data-pjax' => 0,
                    ]
                )
                .'&nbsp;';
            }
        }
    }
}