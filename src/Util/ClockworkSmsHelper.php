<?php

/**
 * This file is part of richardhj/contao-notification_center_clockworksms.
 *
 * Copyright (c) 2016-2018 Richard Henkenjohann
 *
 * @package   richardhj/contao-notification_center_clockworksms
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright 2016-2018 Richard Henkenjohann
 * @license   https://github.com/richardhj/contao-notification_center_clockworksms/blob/master/LICENSE LGPL-3.0
 */


namespace Richardhj\NotificationCenterClockworkSmsBundle\Util;

use Contao\Validator;
use mediaburst\ClockworkSMS\Clockwork;


/**
 * Class ClockworkSmsHelper
 *
 * @package NotificationCenter\Util
 */
class ClockworkSmsHelper
{

    /**
     * Validate e-mail addresses in the comma separated list
     *
     * @param mixed $varValue
     *
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public function validateSmsSender($varValue)
    {
        if ('' !== $varValue) {
            if (false !== strpos($varValue, '##') || false !== strpos($varValue, '{{')) {
                return $varValue;
            }

            if ((!Validator::isAlphanumeric($varValue) && !Clockwork::is_valid_msisdn($varValue))
                || (Validator::isAlphanumeric($varValue) && \strlen($varValue) > 11)
            ) {
                throw new \RuntimeException($GLOBALS['TL_LANG']['ERR']['invalidClockworkSmsSender']);
            }

        }

        return $varValue;
    }


    /**
     * Validate e-mail addresses in the comma separated list
     *
     * @param mixed $varValue
     *
     * @return mixed
     *
     * @throws \RuntimeException
     *
     * @internal param \DataContainer $dc
     */
    public function validatePhoneNumberList($varValue)
    {
        if ('' !== $varValue) {
            foreach (trimsplit(',', $varValue) as $chunk) {
                // Skip string with tokens or inserttags
                if (false !== strpos($chunk, '##') || false !== strpos($chunk, '{{')) {
                    continue;
                }

                if (!Validator::isPhone($chunk)) {
                    throw new \RuntimeException($GLOBALS['TL_LANG']['ERR']['phone']);
                }
            }
        }

        return $varValue;
    }
}
