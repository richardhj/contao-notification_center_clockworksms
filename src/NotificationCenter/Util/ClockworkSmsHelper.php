<?php
/**
 * Clockwork SMS gateway for the notification_center extension for Contao Open Source CMS
 *
 * Copyright (c) 2016 Richard Henkenjohann
 *
 * @package NotificationCenterClockworkSMS
 * @author  Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


namespace NotificationCenter\Util;


/**
 * Class ClockworkSmsHelper
 * @package NotificationCenter\Util
 */
class ClockworkSmsHelper
{

	/**
	 * Validate e-mail addresses in the comma separated list
	 *
	 * @param mixed
	 * @param \DataContainer
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function validateSmsSender($varValue, \DataContainer $dc)
	{
		if ($varValue != '')
		{
			if (strpos($varValue, '##') !== false || strpos($varValue, '{{') !== false)
			{
				return $varValue;
			}

			if ((!\Validator::isAlphanumeric($varValue) && !\Clockwork::is_valid_msisdn($varValue))
				|| (\Validator::isAlphanumeric($varValue) && strlen($varValue) > 11)
			)
			{
				throw new \Exception($GLOBALS['TL_LANG']['ERR']['invalidClockworkSmsSender']);
			}

		}

		return $varValue;
	}


	/**
	 * Validate e-mail addresses in the comma separated list
	 *
	 * @param mixed
	 * @param \DataContainer
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function validatePhoneNumberList($varValue, \DataContainer $dc)
	{
		if ($varValue != '')
		{
			$chunks = trimsplit(',', $varValue);

			foreach ($chunks as $chunk)
			{

				// Skip string with tokens or inserttags
				if (strpos($chunk, '##') !== false || strpos($chunk, '{{') !== false)
				{
					continue;
				}

				if (!\Validator::isPhone($chunk))
				{
					throw new \Exception($GLOBALS['TL_LANG']['ERR']['phone']);
				}
			}
		}

		return $varValue;
	}
}
