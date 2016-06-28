<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;

class UserAccountController extends Controller
{

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
                ->select('id, username text')
                ->from('user')
                ->where(['like', 'username', $term])
                ->limit(20);

            $command        = $query->createCommand();
            $data           = $command->queryAll();
            $out['results'] = array_values($data);
        }
        else if ($id > 0)
        {
            $model = \app\models\User::findOne($id);

            if ($model)
            {
                $out['results'] = [
                    'id'   => $id,
                    'text' => $model->username,
                ];
            }
        }

        return $out;
    }

}