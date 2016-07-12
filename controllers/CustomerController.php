<?php

namespace app\controllers;

use yii\filters\AccessControl;
use app\models\Customer;
use yii\db\Query;

/**
 * This is the class for controller "CustomerController".
 */
class CustomerController extends \app\controllers\base\CustomerController
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
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * provide data for select2 options
     *
     * @param type $term
     * @param type $id
     * @return type
     */
    public function actionOptions($term = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = [
            'results' => [
                'id'   => '',
                'text' => ''
            ],
        ];

        if (!is_null($term))
        {
            $query = new Query;

            $query
                ->select('id, name text')
                ->from('customer')
                ->where(['like', 'name', $term])
                ->limit(20);

            $command        = $query->createCommand();
            $data           = $command->queryAll();
            $out['results'] = array_values($data);
        }
        else if ($id > 0)
        {
            $out['results'] = [
                'id'   => $id,
                'text' => Customer::findOne($id)->name,
            ];
        }

        return $out;
    }

}