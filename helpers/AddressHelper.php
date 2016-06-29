<?php

namespace app\helpers;

use yii\helpers\ArrayHelper;

/**
 * Description of AddressHelper
 *
 * @author fredy
 */
class AddressHelper
{

	/**
	 * @return array
	 */
	public static function defaultParams()
	{
		return [
			// line => [ field => label ]
			'line_1' => [
				'street' => [
					'field' => 'address',
				],
			],
			'line_2' => [
				'subdistrict'	 => [
					'label'	 => 'Subd.',
					'field'	 => 'subdistrict.name',
				],
				'district'		 => [
					'label'	 => 'Dist.',
					'field'	 => 'district.name',
				],
				'city.name',
			],
			'line_3' => [
				'province' => [
					'label'	 => 'Prov.',
					'field'	 => 'province.name',
				],
				'country.name',
				'postcode',
			],
		];

	}

	/**
	 * @param Object $model
	 * @param array $params
	 * @return string
	 */
	public static function completeAddress($model, $params = [])
	{
		if (!$params)
		{
			$params = static::defaultParams();
		}

		$address = [];

		foreach ($params as $line => $items)
		{
			foreach ($items as $key => $item)
			{
				if (is_integer($key) && is_string($item))
				{
					$label = '';
					$field = $item;
				}
				else if (is_array($item))
				{
					$label = ArrayHelper::getValue($item, 'label');
					$field = ArrayHelper::getValue($item, 'field');
				}
				else
				{
					continue;
				}

				$value = ArrayHelper::getValue($model, $field);

				if ($value)
				{
					$address[$line][$field] = trim($label . ' ' . $value);
				}
			}

			if (isset($address[$line]))
			{
				$address[$line] = implode(', ', $address[$line]);
			}
		}

		return implode('<br/>', $address);

	}

}
