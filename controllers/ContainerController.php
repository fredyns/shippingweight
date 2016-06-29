<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\HttpException;
use app\models\Container;
use app\models\form\ContainerForm;

/**
 * This is the class for controller "ContainerController".
 */
class ContainerController extends \app\controllers\base\ContainerController
{

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $login = (Yii::$app->user->isGuest == FALSE);

        if ($login == FALSE)
        {
            throw new HttpException(404, 'You have to login.');
        }

        $model = new ContainerForm();

        if (Yii::$app->user->identity->isAdmin == FALSE)
        {
            $model->user_id = Yii::$app->user->id;
        }

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
        if (Yii::$app->user->isGuest)
        {
            throw new HttpException(404, 'You have to login.');
        }

        $model = $this->findForm($id);
        $owned = ($model->shipper->user_id == Yii::$app->user->id);

        if ($owned == FALSE && Yii::$app->user->identity->isAdmin == FALSE)
        {
            throw new HttpException(404, 'It is not yours to update.');
        }

        if ($model->status == Container::STATUS_VERIFIED)
        {
            throw new HttpException(404, 'This Container has already Verified.');
        }

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
        try
        {
            $model        = $this->findModel($id);
            $login        = (Yii::$app->user->isGuest == FALSE);
            $owned        = ($model->shipper->user_id == Yii::$app->user->id);
            $permit       = ($owned OR Yii::$app->user->identity->isAdmin);
            $registerOnly = ($model->status == Container::STATUS_REGISTERED);

            if ($login && $permit && $registerOnly)
            {
                $model->delete();
            }

            if ($login == FALSE)
            {
                throw new HttpException(404, 'You have to login.');
            }

            if ($permit == FALSE)
            {
                throw new HttpException(404, 'This container is not yours to delete.');
            }

            if ($registerOnly == FALSE)
            {
                throw new HttpException(404, 'This shipper has containers.');
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