<?php
/**
 * Clockwork SMS gateway for the notification_center extension for Contao Open Source CMS
 *
 * Copyright (c) 2016 Richard Henkenjohann
 *
 * @package NotificationCenterClockworkSMS
 * @author  Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */

namespace NotificationCenter\MessageDraft;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use NotificationCenter\Model\Language;
use NotificationCenter\Model\Message;
use NotificationCenter\Util\String;


/**
 * Class ClockworkSmsMessageDraft
 * @package NotificationCenter\MessageDraft
 */
class ClockworkSmsMessageDraft implements MessageDraftInterface
{
	/**
	 * Message
	 * @var Message|\Model
	 */
	protected $objMessage;


	/**
	 * Language
	 * @var Language|\Model
	 */
	protected $objLanguage;


	/**
	 * Tokens
	 * @var array
	 */
	protected $arrTokens = array();


	/**
	 * Construct the object
	 *
	 * @param Message  $objMessage
	 * @param Language $objLanguage
	 * @param          $arrTokens
	 */
	public function __construct(Message $objMessage, Language $objLanguage, $arrTokens)
	{
		$this->arrTokens = $arrTokens;
		$this->objLanguage = $objLanguage;
		$this->objMessage = $objMessage;
	}


	/**
	 * @return string|null
	 */
	public function getFrom()
	{
		return String::recursiveReplaceTokensAndTags($this->objLanguage->sms_sender, $this->arrTokens, String::NO_TAGS | String::NO_EMAILS | String::NO_BREAKS) ?: null;
	}


	/**
	 * @return array
	 */
	public function getRecipients()
	{
		// Replaces tokens first so that tokens can contain a list of recipients.
		$strRecipients = String::recursiveReplaceTokensAndTags($this->objLanguage->sms_recipients, $this->arrTokens, String::NO_TAGS | String::NO_EMAILS | String::NO_BREAKS);
		$arrRecipients = array();

		foreach ((array)trimsplit(',', $strRecipients) as $strRecipient)
		{
			if ($strRecipient != '')
			{
				$strRecipient = String::recursiveReplaceTokensAndTags($strRecipient, $this->arrTokens, String::NO_TAGS | String::NO_EMAILS | String::NO_BREAKS);
				$strRecipient = $this->normalizePhoneNumber($strRecipient);

				// Address could become empty through invalid insert tag
				if ($strRecipient === false || !\Clockwork::is_valid_msisdn($strRecipient))
				{
					\System::log(sprintf('Recipient "%s" for message ID %s was skipped as it was no valid MSISDN.',
						$strRecipient,
						$this->objMessage->id),
						__METHOD__, TL_ERROR);
					continue;
				}

				$arrRecipients[] = $strRecipient;
			}
		}

		return $arrRecipients;
	}


	/**
	 * Try to normalize a given phone number string
	 *
	 * @param $strPhone
	 *
	 * @return string|false in case of failing
	 */
	protected function normalizePhoneNumber($strPhone)
	{
		$objPhoneNumberUtil = PhoneNumberUtil::getInstance();

		try
		{
			// We have to find a default country code as we can not make sure to get a internationalized phone number
			$strDefaultRegion =
				(String::recursiveReplaceTokensAndTags($this->objLanguage->sms_recipients_region, $this->arrTokens, String::NO_TAGS | String::NO_EMAILS | String::NO_BREAKS))
				?: $this->objLanguage->language;

			$phoneNumber = $objPhoneNumberUtil->parse($strPhone, strtoupper($strDefaultRegion));

			return ltrim($objPhoneNumberUtil->format($phoneNumber, PhoneNumberFormat::E164), '+');

		} catch (NumberParseException $e)
		{
			\System::log(sprintf('Failed to normalize phone number "%s" with message "%s"',
				$strPhone,
				$e->getMessage()),
				__METHOD__, TL_ERROR);
		}

		return false;
	}


	/**
	 * Returns the message
	 * @return string
	 */
	public function getText()
	{
		$strText = $this->objLanguage->sms_text;
		$strText = String::recursiveReplaceTokensAndTags($strText, $this->arrTokens, String::NO_TAGS);

		return \Controller::convertRelativeUrls($strText, '', true);
	}


	/**
	 * {@inheritdoc}
	 */
	public function getTokens()
	{
		return $this->arrTokens;
	}
	

	/**
	 * {@inheritdoc}
	 */
	public function getMessage()
	{
		return $this->objMessage;
	}
	

	/**
	 * {@inheritdoc}
	 */
	public function getLanguage()
	{
		return $this->objLanguage->language;
	}
}
