<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use dektrium\user\models\Profile as BaseProfile;

/**
 * This is the model class for table "profile".
 *
 * @property string  $npwp
 * @property string  $cp
 * @property string  $phone
 */
class Profile extends BaseProfile
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
                parent::rules(),
                [
                'nameRequired'     => ['name', 'required'],
                'locationRequired' => ['location', 'required'],
                'npwpRequired'     => ['npwp', 'required'],
                'cpRequired'       => ['cp', 'required'],
                'phoneRequired'    => ['phone', 'required'],
                //'public_emailRequired' => ['public_email', 'required'],
                'npwpLength'       => ['npwp', 'string', 'max' => 64],
                'cpLength'         => ['cp', 'string', 'max' => 255],
                'phoneLength'      => ['phone', 'string', 'max' => 255],
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
                parent::attributeLabels(),
                [
                'name'     => 'Name / Company',
                'location' => 'Address',
                'npwp'     => 'NPWP',
                'cp'       => 'Contact Person',
                'phone'    => 'Phone',
                ]
        );
    }

}