<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\HttpException;
use app\models\Container;
use app\models\Weighing;
use app\models\form\ContainerForm;
use app\libraries\TPKS;
use yii\base\UserException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\GoneHttpException;
use app\models\search\ContainerSearch;
use dmstr\bootstrap\Tabs;

/**
 * This is the class for controller "ContainerController".
 */
class ContainerController extends \app\controllers\base\ContainerController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $searchModel  = new ContainerSearch;
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        $view = 'index';

        return $this->render($view,
                [
                'dataProvider' => $dataProvider,
                'searchModel'  => $searchModel,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model = new ContainerForm();

        $model->setScenario('create');

        /**
         * selama trial status container "ready" agar langsung bisa cetak VGM
         */
        $model->status = Container::STATUS_READY;

        try
        {
            if ($model->load($_POST) && $model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            elseif (!\Yii::$app->request->isPost)
            {
                $model->load($_GET);
            }
        }
        catch (\Exception $e)
        {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();

            $model->addError('_exception', $msg);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $model = $this->findForm($id);
        $owned = ($model->shipper->user_id == Yii::$app->user->id);

        if ($owned == FALSE && Yii::$app->user->identity->isAdmin == FALSE)
        {
            throw new UnauthorizedHttpException('This Container is not yours to update.');
        }

        $scenario = ($model->status == Container::STATUS_VERIFIED) ? 'semi-update' : 'update';

        $model->setScenario($scenario);

        if ($model->load($_POST) && $model->save())
        {
            return $this->redirect(Url::previous());
        }
        else
        {
            return $this->render('update', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest)
        {
            $admin = FALSE;
        }
        else
        {
            $admin = Yii::$app->user->identity->isAdmin;
        }

        try
        {
            $model        = $this->findModel($id);
            $owned        = ($model->created_by == Yii::$app->user->id);
            $statusPermit = ($model->status !== Container::STATUS_VERIFIED);
            $selfDelete   = ($owned && $statusPermit);

            if ($admin OR $selfDelete)
            {
                $model->delete();
            }

            if (Yii::$app->user->isGuest)
            {
                throw new HttpException(404, 'You have to login.');
            }

            if ($owned == FALSE)
            {
                throw new HttpException(404, 'This container is not yours to delete.');
            }

            if ($statusPermit == FALSE)
            {
                throw new HttpException(404, 'This container alrady paid or verified.');
            }

            throw new HttpException(404, 'Unknown error.');
        }
        catch (\Exception $e)
        {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();

            \Yii::$app->getSession()->addFlash('error', $msg);

            return $this->redirect(Url::previous());
        }

        // TODO: improve detection
        $isPivot = strstr('$id', ',');

        if ($isPivot == true)
        {
            return $this->redirect(Url::previous());
        }
        elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/')
        {
            Url::remember(null);

            $url                                   = \Yii::$app->session['__crudReturnUrl'];
            \Yii::$app->session['__crudReturnUrl'] = null;

            return $this->redirect($url);
        }
        else
        {
            return $this->redirect(['index']);
        }
    }

    /**
     * bill payment
     *
     * @param int $id
     * @return mixed
     * @throws HttpException
     */
    public function actionPayment($id)
    {
        $model        = $this->findForm($id);
        $permit       = (Yii::$app->user->identity->isAdmin);
        $registerOnly = ($model->status == Container::STATUS_REGISTERED);

        // black list

        if ($permit == FALSE)
        {
            throw new HttpException(404, 'Who are you?');
        }

        if ($registerOnly == FALSE)
        {
            throw new HttpException(404, 'This Container has already Paid.');
        }

        $model->setScenario('payment');

        if ($model->paying())
        {
            return $this->redirect(Url::previous());
        }
        else
        {
            return $this->render('payment', [
                    'model' => $model,
            ]);
        }
    }

    public function actionApi($container_number)
    {

        $vgm = TPKS::container($container_number);

        return '<pre>'.print_r($vgm, TRUE);
    }

    public function actionCheck($id)
    {
        // buka data

        $model = $this->findModel($id);
        $owned = ($model->shipper->user_id == Yii::$app->user->id);

        // cek user

        if ($owned == FALSE && Yii::$app->user->identity->isAdmin == FALSE)
        {
            throw new UnauthorizedHttpException('This Container is not yours to check.');
        }

        // cek status barang

        if ($model->status == Container::STATUS_REGISTERED)
        {
            throw new UserException('This Container is not yet paid.');
        }
        elseif ($model->status == Container::STATUS_VERIFIED)
        {
            //throw new GoneHttpException('This Container is already Verified.');
        }
        elseif ($model->status != Container::STATUS_READY)
        {
            throw new HttpException(404, 'This Container is not ready.');
        }

        try
        {
            $result = $model->checkVGM();
        }
        catch (\Exception $e)
        {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();

            \Yii::$app->getSession()->addFlash('error', $msg);

            return $this->redirect(Url::previous());
        }

        // TODO: improve detection
        $isPivot = strstr('$id', ',');

        if ($isPivot == true)
        {
            return $this->redirect(Url::previous());
        }
        elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/')
        {
            Url::remember(null);

            $url                                   = \Yii::$app->session['__crudReturnUrl'];
            \Yii::$app->session['__crudReturnUrl'] = null;

            return $this->redirect($url);
        }
        else
        {
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    protected function findForm($id)
    {
        if (($model = ContainerForm::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }

}