<?php
/*
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace alxmsl\Telegram\Bot;

use alxmsl\Network\Http\Request;
use alxmsl\Telegram\Bot\Exception\UnsuccessfulException;
use alxmsl\Telegram\Bot\Type\ForceReply;
use alxmsl\Telegram\Bot\Type\Message;
use alxmsl\Telegram\Bot\Type\ReplyKeyboardHide;
use alxmsl\Telegram\Bot\Type\ReplyKeyboardMarkup;
use alxmsl\Telegram\Bot\Type\Update;
use alxmsl\Telegram\Bot\Type\User;
use alxmsl\Telegram\Bot\Type\UserProfilePhotos;
use Closure;
use CURLFile;
use JsonSerializable;
use stdClass;

/**
 * Telegram Bot API client
 * @author alxmsl
 */
class Client {
    /**
     * Telegram API endpoint
     */
    const ENDPOINT_URI = 'https://api.telegram.org';

    /**
     * @var string authentication token
     */
    private $token = '';

    /**
     * @var int connect timeout, seconds
     */
    private $connectTimeout = 0;

    /**
     * @var int request timeout, seconds
     */
    private $requestTimeout = 0;

    /**
     * @param int $connectTimeout connect timeout, seconds
     * @return $this
     */
    public function setConnectTimeout($connectTimeout) {
        $this->connectTimeout = (int) $connectTimeout;
        return $this;
    }

    /**
     * @return int connect timeout, seconds
     */
    public function getConnectTimeout() {
        return $this->connectTimeout;
    }

    /**
     * @param int $requestTimeout request timeout, seconds
     * @return $this
     */
    public function setRequestTimeout($requestTimeout) {
        $this->requestTimeout = (int) $requestTimeout;
        return $this;
    }

    /**
     * @return int request timeout, seconds
     */
    public function getRequestTimeout() {
        return $this->requestTimeout;
    }

    /**
     * @param string $token client authentication token
     */
    public function __construct($token = '') {
        $this->token = (string) $token;
    }

    /**
     * Get basic information about the bot
     * @return User bot user instance
     */
    public function getMe() {
        return $this->getResult('getMe', [], function(stdClass $User) {
            return User::initializeByObject($User);
        });
    }

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
    public function sendMessage($chatId, $text, $disableWebPagePreview = null, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id' => (int) $chatId,
            'text'    => (string) $text,
        ];
        if (!is_null($disableWebPagePreview)) {
            $parameters['disable_web_page_preview'] = (bool) $disableWebPagePreview;
        }
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('getUpdates', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * Method to forward messages of any kind
     * @param int $chatId unique identifier for the message recipient
     * @param int $fromChatId unique identifier for the chat where the original message was sent
     * @param int $messageId unique message identifier
     * @return Message forwarded message
     */
    public function forwardMessage($chatId, $fromChatId, $messageId) {
        return $this->getResult('forwardMessage', [
            'chat_id'      => (int) $chatId,
            'from_chat_id' => (int) $chatId,
            'message_id'   => (int) $chatId,
        ], function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

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
    public function sendPhoto($chatId, $Photo, $caption = '', $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id' => (int) $chatId,
            'photo'   => $Photo,
        ];
        if (!empty($caption)) {
            $parameters['caption'] = (bool) $caption;
        }
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendPhoto', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

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
    public function sendPhotoByFileId($chatId, $fileId, $caption = '', $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        return $this->sendPhoto($chatId, (string) $fileId, $caption, $replyToMessageId, $ReplyMarkUp);
    }

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
    public function sendPhotoFile($chatId, $fileName, $caption = '', $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $File = new CURLFile($fileName);
        return $this->sendPhoto($chatId, $File, $caption, $replyToMessageId, $ReplyMarkUp);
    }

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
    public function sendAudio($chatId, $Audio, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id' => (int) $chatId,
            'audio'   => $Audio,
        ];
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendAudio', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * Method to send audio
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileId identifier of the audio that is already on the Telegram servers
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendAudioByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        return $this->sendAudio($chatId, (string) $fileId, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * Method to send audio
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileName path for upload a new audio from file
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendAudioByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $File = new CURLFile($fileName);
        return $this->sendAudio($chatId, $File, $replyToMessageId, $ReplyMarkUp);
    }

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
    public function sendDocument($chatId, $Document, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id'  => (int) $chatId,
            'document' => $Document,
        ];
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendDocument', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * Method to send document
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileId identifier of the document that is already on the Telegram servers
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendDocumentByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        return $this->sendDocument($chatId, (string) $fileId, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * Method to send document
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileName path for upload a new document from file
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendDocumentByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $File = new CURLFile($fileName);
        return $this->sendDocument($chatId, $File, $replyToMessageId, $ReplyMarkUp);
    }

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
    public function sendSticker($chatId, $Sticker, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id' => (int) $chatId,
            'sticker'   => $Sticker,
        ];
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendSticker', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * Method to send sticker
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileId identifier of the sticker that is already on the Telegram servers
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendStickerByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        return $this->sendsticker($chatId, (string) $fileId, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * Method to send sticker
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileName path for upload a new sticker from file
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendStickerByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $File = new CURLFile($fileName);
        return $this->sendsticker($chatId, $File, $replyToMessageId, $ReplyMarkUp);
    }

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
    public function sendVideo($chatId, $Video, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id' => (int) $chatId,
            'video'   => $Video,
        ];
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendVideo', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * Method to send video
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileId identifier of the video that is already on the Telegram servers
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendVideoByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        return $this->sendvideo($chatId, (string) $fileId, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * Method to send video
     * @param int $chatId unique identifier for the message recipient
     * @param string $fileName path for upload a new video from file
     * @param int|null $replyToMessageId if the message is a reply, ID of the original message
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply|JsonSerializable $ReplyMarkUp object for a custom reply
     * keyboard, instructions to hide keyboard or to force a reply from the user
     * @return Message sent message instance
     */
    public function sendVideoByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $File = new CURLFile($fileName);
        return $this->sendvideo($chatId, $File, $replyToMessageId, $ReplyMarkUp);
    }

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
    public function sendLocation($chatId, $latitude, $longitude, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id'   => (int) $chatId,
            'latitude'  => (float) $latitude,
            'longitude' => (float) $longitude,
        ];
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendVideo', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * Method when you need to tell the user that something is happening on the bot's side
     * @param int $chatId unique identifier for the message recipient
     * @param string $action type of action to broadcast.
     * @see Action class for constantst
     * @return mixed result data
     */
    public function sendChatAction($chatId, $action) {
        return $this->getResult('sendChatAction', [
            'chat_id' => (int) $chatId,
            'action'  => (string) $action,
        ]);
    }

    /**
     * Method to get a list of profile pictures for a user
     * @param int $userId unique identifier of the target user
     * @param null|int $offset sequential number of the first photo to be returned
     * @param null|int $limit limits the number of photos to be retrieved
     * @return UserProfilePhotos profile photos
     */
    public function getUserProfilePhotos($userId, $offset = null, $limit = null) {
        $parameters = [
            'user_id' => (int) $userId,
        ];
        if (!is_null($offset)) {
            $parameters['offset'] = (int) $offset;
        }
        if (!is_null($limit)) {
            $parameters['limit'] = (int) $limit;
        }
        return $this->getResult('sendVideo', $parameters, function(stdClass $Photos) {
            return UserProfilePhotos::initializeByObject($Photos);
        });
    }

    /**
     * Receive incoming updates using long polling
     * @param int|null $offset identifier of the first update to be returned
     * @param int|null $limit limits the number of updates to be retrieved
     * @param int|null $timeout timeout in seconds for long polling
     * @return Update[] received updates
     */
    public function getUpdates($offset = null, $limit = null, $timeout = null) {
        $parameters = [];
        if (!is_null($offset)) {
            $parameters['offset'] = (int) $offset;
        }
        if (!is_null($limit)) {
            $parameters['limit'] = (int) $limit;
        }
        if (!is_null($timeout)) {
            $parameters['timeout'] = (int) $timeout;
        }
        return $this->getResult('getUpdates', $parameters, function(stdClass $UpdateObject) {
            return Update::initializeByObject($UpdateObject);
        });
    }

    /**
     * Method to specify a url and receive incoming updates via an outgoing webhook
     * @param string $url HTTPS url to send updates to
     * @return mixed method response
     */
    public function setWebhook($url) {
        return $this->getResult('setWebhook', [
            'url' => $url,
        ]);
    }

    /**
     * Remove webhook integration method
     * @return mixed method response
     */
    public function removeWebhook() {
        return $this->setWebhook('');
    }

    /**
     * Call bot method and return result instance
     * @param string $methodName API method name
     * @param array $parameters method call parameters
     * @param Closure $BuildStrategy build strategy for response result(s)
     * @return mixed response result instance
     * @throws UnsuccessfulException exception for unsuccessful request responses
     */
    private function getResult($methodName, array $parameters = [], Closure $BuildStrategy = null) {
        $responseData = $this->call($methodName, $parameters, $BuildStrategy);
        $Response     = Response::initializeByString($responseData, $BuildStrategy);
        if (!$Response->isOk()) {
            throw new UnsuccessfulException($Response->getDescription(), $Response->getErrorCode());
        } else {
            return $Response->getResult();
        }
    }

    /**
     * Call bot method
     * @param string $methodName API method name
     * @param array $parameters method call parameters
     * @return string response data
     */
    public function call($methodName, array $parameters = []) {
        $Request = $this->getRequest()
            ->addUrlField(sprintf('bot%s', $this->token), $methodName);
        if (!empty($parameters)) {
            $Request->setPostData($parameters);
        }
        return $Request->send();
    }

    /**
     * @return Request request object
     */
    private function getRequest() {
        $Request = new Request();
        $Request->setTransport(Request::TRANSPORT_CURL);
        return $Request->setUrl(self::ENDPOINT_URI)
            ->setConnectTimeout($this->getConnectTimeout())
            ->setTimeout($this->getRequestTimeout());
    }
}
