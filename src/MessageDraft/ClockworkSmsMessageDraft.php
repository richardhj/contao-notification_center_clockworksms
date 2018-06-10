<?php

/**
 * This file is part of richardhj/contao-notification_center_clockworksms.
 *
 * Copyright (c) 2016-2018 Richard Henkenjohann
 *
 * @package   richardhj/contao-notification_center_member_selectable
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright 2016-2018 Richard Henkenjohann
 * @license   https://github.com/richardhj/contao-notification_center_member_selectable/blob/master/LICENSE LGPL-3.0
 */

namespace Richardhj\NotificationCenterClockworkSmsBundle\MessageDraft;

use Contao\Controller;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\System;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use mediaburst\ClockworkSMS\Clockwork;
use NotificationCenter\MessageDraft\MessageDraftInterface;
use NotificationCenter\Model\Language;
use NotificationCenter\Model\Message;
use NotificationCenter\Util\StringUtil;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;


/**
 * Class ClockworkSmsMessageDraft
 *
 * @package NotificationCenter\MessageDraft
 */
class ClockworkSmsMessageDraft implements MessageDraftInterface
{

    /**
     * Message
     *
     * @var Message|\Model
     */
    protected $objMessage;

    /**
     * Language
     *
     * @var Language|\Model
     */
    protected $objLanguage;

    /**
     * Tokens
     *
     * @var array
     */
    protected $arrTokens = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Construct the object
     *
     * @param Message  $message
     * @param Language $language
     * @param array    $tokens
     */
    public function __construct(Message $message, Language $language, array $tokens)
    {
        $this->arrTokens   = $tokens;
        $this->objLanguage = $language;
        $this->objMessage  = $message;

        $this->logger = System::getContainer()->get('monolog.logger.contao');
    }

    /**
     * @return string|null
     */
    public function getFrom()
    {
        return StringUtil::recursiveReplaceTokensAndTags(
            $this->objLanguage->sms_sender,
            $this->arrTokens,
            StringUtil::NO_TAGS | StringUtil::NO_EMAILS | StringUtil::NO_BREAKS
        ) ?: null;
    }

    /**
     * @return array
     */
    public function getRecipients()
    {
        // Replaces tokens first so that tokens can contain a list of recipients.
        $strRecipients = StringUtil::recursiveReplaceTokensAndTags(
            $this->objLanguage->sms_recipients,
            $this->arrTokens,
            StringUtil::NO_TAGS | StringUtil::NO_EMAILS | StringUtil::NO_BREAKS
        );
        $arrRecipients = [];

        foreach (trimsplit(',', $strRecipients) as $strRecipient) {
            if ('' !== $strRecipient) {
                $strRecipient = StringUtil::recursiveReplaceTokensAndTags(
                    $strRecipient,
                    $this->arrTokens,
                    StringUtil::NO_TAGS | StringUtil::NO_EMAILS | StringUtil::NO_BREAKS
                );
                $strRecipient = $this->normalizePhoneNumber($strRecipient);

                // Address could become empty through invalid insert tag
                if (false === $strRecipient || !Clockwork::is_valid_msisdn($strRecipient)) {
                    $this->logger->log(
                        LogLevel::ERROR,
                        sprintf(
                            'Recipient "%s" for message ID %s was skipped as it was no valid MSISDN.',
                            $strRecipient,
                            $this->objMessage->id
                        ),
                        array('contao' => new ContaoContext(__METHOD__, TL_ERROR))
                    );

                    continue;
                }

                $arrRecipients[] = $strRecipient;
            }
        }

        return $arrRecipients;
    }

    /**
     * Returns the message
     *
     * @return string
     */
    public function getText()
    {
        $strText = $this->objLanguage->sms_text;
        $strText = StringUtil::recursiveReplaceTokensAndTags($strText, $this->arrTokens, StringUtil::NO_TAGS);

        return Controller::convertRelativeUrls($strText, '', true);
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

    /**
     * Try to normalize a given phone number string
     *
     * @param $phone
     *
     * @return string|false in case of failing
     */
    protected function normalizePhoneNumber($phone)
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();

        try {
            // We have to find a default country code as we can not make sure to get a internationalized phone number
            $strDefaultRegion =
                StringUtil::recursiveReplaceTokensAndTags(
                    $this->objLanguage->sms_recipients_region,
                    $this->arrTokens,
                    StringUtil::NO_TAGS | StringUtil::NO_EMAILS | StringUtil::NO_BREAKS
                )
                    ?: $this->objLanguage->language;

            $phoneNumber = $phoneNumberUtil->parse($phone, strtoupper($strDefaultRegion));

            return ltrim($phoneNumberUtil->format($phoneNumber, PhoneNumberFormat::E164), '+');

        } catch (NumberParseException $e) {
            $this->logger->log(
                LogLevel::ERROR,
                sprintf(
                    'Failed to normalize phone number "%s" with message "%s"',
                    $phone,
                    $e->getMessage()
                ),
                array('contao' => new ContaoContext(__METHOD__, TL_ERROR))
            );
        }

        return false;
    }
}
