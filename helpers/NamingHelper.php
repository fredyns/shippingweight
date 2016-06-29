<?php

namespace app\helpers;

/**
 * Description of NamingHelper
 *
 * @author fredy
 */
class NamingHelper
{

	public function alternateName($prefix = '', $name = '', $suffix = '')
	{
		$name = trim($name . ', ' . $suffix, ", \t\n\r\0\x0B");

		if (strlen($prefix) > 0)
		{
			$name .= ' (' . $prefix . ')';
		}

		return $name;

	}

	public function officialName($prefix = '', $name = '', $suffix = '')
	{
		return trim($prefix . ' ' . $name . ', ' . $suffix, ", \t\n\r\0\x0B");

	}

}
