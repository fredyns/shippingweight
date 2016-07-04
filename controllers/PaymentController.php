<?php

namespace app\controllers;

use Yii;
use app\models\form\PaymentForm;
use app\models\search\PaymentContainer;

/**
 * This is the class for controller "PaymentController".
 */
class PaymentController extends \app\controllers\base\PaymentController
{

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest)
        {
            throw new HttpException(404, 'You have to login.');
        }

        if (Yii::$app->user->identity->isAdmin == FALSE)
        {
            throw new HttpException(404, 'You are not permitted.');
        }

        $model = new PaymentForm;

        if (\Yii::$app->request->isPost)
        {
            if ($model->create())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else
        {
            $model->load($_GET);
        }

        $containerSearch = new PaymentContainer;
        $containersData  = $containerSearch->search($_GET);

        return $this->render(
                'create',
                [
                'model'           => $model,
                'containersData'  => $containersData,
                'containerSearch' => $containerSearch,
                ]
        );
    }

    public function saveCreate()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try
        {
            if ($model->load($_POST) && $model->save())
            {
                $transaction->commit();

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

            $transaction->rollback();
            $model->addError('_exception', $msg);
        }
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

        if (Yii::$app->user->identity->isAdmin == FALSE)
        {
            throw new HttpException(404, 'You are not permitted.');
        }

        $model = $this->findForm($id);

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
            throw new HttpException(404, 'You have to login.');
        }

        $permit = (Yii::$app->user->identity->isAdmin);

        if ($permit == FALSE)
        {
            throw new HttpException(404, 'This container is not yours to delete.');
        }

        try
        {
            $this->findModel($id)->delete();
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
        if (($model = PaymentForm::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }

}