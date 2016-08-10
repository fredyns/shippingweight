<?php

namespace app\models;

use Yii;
use \app\models\base\Transfer as BaseTransfer;

/**
 * This is the model class for table "transfer".
 */
class Transfer extends BaseTransfer
{

    public function findContainers()
    {
        $containerList = $this->containerList_all;
        $containerList = \app\helpers\FilterHelper::stripSpaces($containerList);

        if (empty($containerList))
        {
            return;
        }

        $containerList = strtoupper($containerList);
        $containerList = str_replace(' ', ',', $containerList);
        $containerList = str_replace(chr(13), ',', $containerList);

        $containerNumbers = explode(',', $containerList);
        $containerNumbers = array_filter($containerNumbers);
        $containerNumbers = array_filter($containerNumbers,
            function ($val)
        {
            return (strpos($val, '(') === FALSE);
        });
        $this->containerList_all = implode(', ', $containerNumbers);

        $containers = Container::findAll(['number' => $containerNumbers, 'transfer_id' => null]);

        $containerConfirmed   = [];
        $this->containerCount = 0;

        foreach ($containers as $container)
        {
            $this->containerCount++;
            $container->transfer_id = $this->id;
            $containerConfirmed[]   = $container->number;

            $container->save(FALSE);
        }

        $containerList_missed          = array_diff($containerNumbers, $containerConfirmed);
        $this->containerList_all       = implode(', ', $containerNumbers).chr(13).'( '.count($containerNumbers).' )';
        $this->containerList_confirmed = implode(', ', $containerConfirmed).chr(13).'( '.count($containerConfirmed).' )';
        $this->containerList_missed    = trim(implode(', ', $containerList_missed).chr(13).'( '.count($containerList_missed).' )');

        $this->save(FALSE);
    }

    public function removeContainers()
    {
        $this
            ->getDb()
            ->createCommand()
            ->update('container', ['transfer_id' => null], ['transfer_id' => $this->id])
            ->execute();
    }

}