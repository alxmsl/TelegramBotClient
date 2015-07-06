<?php

namespace alxmsl\Telegram\Bot;
use alxmsl\Telegram\Bot\Type\ForceReply;
use alxmsl\Telegram\Bot\Type\Message;
use alxmsl\Telegram\Bot\Type\ReplyKeyboardHide;
use alxmsl\Telegram\Bot\Type\ReplyKeyboardMarkup;
use alxmsl\Telegram\Bot\Type\Update;
use alxmsl\Telegram\Bot\Type\User;
use alxmsl\Telegram\Bot\Type\UserProfilePhotos;
use CURLFile;
use JsonSerializable;

/**
 * Telegram Bot API interface
 * @author alxmsl
 */
interface ClientInterface {
    /**
     * Get basic information about the bot
     * @return User bot user instance
     */
    public function getMe();

    /**
     * Send text message
     * @param int $chatId unique identifier for the message recipient
     * @param string $text text of the message to be sent
     * @param bool|null $disableWebPagePreview disables link previews for links in this message
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendMessage($chatId, $text, $disableWebPagePreview = null, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to forward messages of any kind
     * @param int $chatId unique identifier for the message recipient
     * @param int $fromChatId unique identifier for the chat where the original message was sent
     * @param int $messageId unique message identifier
     * @return Message forwarded message
     */
    public function forwardMessage($chatId, $fromChatId, $messageId);

    /**
     * Method to send photo
     * @param int $chatId unique identifier for the message recipient
     * @param CURLFile|string $Photo photo to send - photo that is already on the Telegram servers, or upload a new photo
     * @param string $caption photo caption
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendPhoto($chatId, $Photo, $caption = '', $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send photo
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileId identifier of the photo that is already on the Telegram servers
     * @param string $caption photo caption
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendPhotoByFileId($chatId, $fileId, $caption = '', $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send photo
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileName path for upload a new photo from file
     * @param string $caption photo caption
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendPhotoFile($chatId, $fileName, $caption = '', $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send audio
     * @param int $chatId unique identifier for the message recipient
     * @param CURLFile|string $Audio audio to send - audio that is already on the Telegram servers, or upload a new
     * audio
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendAudio($chatId, $Audio, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send audio
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileId identifier of the audio that is already on the Telegram servers
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendAudioByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send audio
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileName path for upload a new audio from file
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendAudioByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send document
     * @param int $chatId unique identifier for the message recipient
     * @param CURLFile|string $Document document to send - document that is already on the Telegram servers, or upload a
     * new document
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendDocument($chatId, $Document, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send document
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileId identifier of the document that is already on the Telegram servers
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendDocumentByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send document
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileName path for upload a new document from file
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendDocumentByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send sticker
     * @param int $chatId unique identifier for the message recipient
     * @param CURLFile|string $Sticker sticker to send - sticker that is already on the Telegram servers, or upload a new
     * sticker
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendSticker($chatId, $Sticker, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send sticker
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileId identifier of the sticker that is already on the Telegram servers
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendStickerByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send sticker
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileName path for upload a new sticker from file
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendStickerByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send video
     * @param int $chatId unique identifier for the message recipient
     * @param CURLFile|string $Video video to send - video that is already on the Telegram servers, or upload a new
     * video
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendVideo($chatId, $Video, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send video
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileId identifier of the video that is already on the Telegram servers
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendVideoByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send video
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileName path for upload a new video from file
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendVideoByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method to send location
     * @param int $chatId unique identifier for the message recipient
     * @param float $latitude latitude of location
     * @param float $longitude longitude of location
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendLocation($chatId, $latitude, $longitude, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null);

    /**
     * Method when you need to tell the user that something is happening on the bot's side
     * @param int $chatId unique identifier for the message recipient
     * @param string $action type of action to broadcast.
     * @see Action class for constantst
     * @return mixed result data
     */
    public function sendChatAction($chatId, $action);

    /**
     * Method to get a list of profile pictures for a user
     * @param int $userId unique identifier of the target user
     * @param null|int $offset sequential number of the first photo to be returned
     * @param null|int $limit limits the number of photos to be retrieved
     * @return UserProfilePhotos profile photos
     */
    public function getUserProfilePhotos($userId, $offset = null, $limit = null);

    /**
     * Receive incoming updates using long polling
     * @param int|null $offset identifier of the first update to be returned
     * @param int|null $limit limits the number of updates to be retrieved
     * @param int|null $timeout timeout in seconds for long polling
     * @return Update[] received updates
     */
    public function getUpdates($offset = null, $limit = null, $timeout = null);

    /**
     * Method to specify a url and receive incoming updates via an outgoing webhook
     * @param string $url HTTPS url to send updates to
     * @return mixed method response
     */
    public function setWebhook($url);

    /**
     * Remove webhook integration method
     * @return mixed method response
     */
    public function removeWebhook();

    /**
     * Call bot method
     * @param string $methodName API method name
     * @param array $parameters method call parameters
     * @return string response data
     */
    public function call($methodName, array $parameters = []);
}
