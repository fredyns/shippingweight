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

        //sort($containerNumbers);

        if (!$this->containerCount)
        {
            $this->containerCount = count($containerNumbers);
        }

        $containerInputQty = array_count_values($containerNumbers);
        $containerInputQty = array_filter($containerInputQty,
            function ($val)
        {
            return ($val > 1);
        });

        if ($containerInputQty)
        {
            //$containerNumbers = array_unique($containerNumbers);
            $duplicate = [];

            foreach ($containerInputQty as $contNumber => $qty)
            {
                $duplicate[] = $contNumber.' ('.$qty.')';
            }

            $this->note .= chr(13).chr(13).'Input ganda: '.implode(', ', $duplicate).'.';
        }

        $this->containerList_all = implode(', ', $containerNumbers);

        $containers = Container::find()
            ->where(['number' => $containerNumbers, 'transfer_id' => null])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $containerConfirmed = [];
        $containerDuplicate = [];
        //$this->containerCount = 0;

        foreach ($containers as $container)
        {
            if (in_array($container->number, $containerConfirmed))
            {
                if (array_key_exists($container->number, $containerDuplicate))
                {
                    $containerDuplicate[$container->number] ++;
                }
                else
                {
                    $containerDuplicate[$container->number] = 2;
                }

                //continue;
            }

            //$this->containerCount++;
            $container->transfer_id = $this->id;
            $containerConfirmed[]   = $container->number;

            $container->save(FALSE);
        }

        if ($containerDuplicate)
        {
            ksort($containerDuplicate);

            $duplicate = [];

            foreach ($containerDuplicate as $contNumber => $qty)
            {
                $duplicate[] = $contNumber.' ('.$qty.')';
            }

            $this->note .= chr(13).chr(13).'Kontainer ganda: '.implode(', ', $duplicate).'.';
        }

        $containerList_missed = array_diff($containerNumbers, $containerConfirmed);

        sort($containerConfirmed);
        sort($containerList_missed);

        $this->containerList_all       = implode(', ', $containerNumbers).chr(13).'('.count($containerNumbers).')';
        $this->containerList_confirmed = implode(', ', $containerConfirmed).chr(13).'('.count($containerConfirmed).')';
        $this->containerList_missed    = trim(implode(', ', $containerList_missed).chr(13).'('.count($containerList_missed).')');

        if (is_numeric($this->amount) == FALSE)
        {
            $this->amount = $this->containerCount * 66000;
        }

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