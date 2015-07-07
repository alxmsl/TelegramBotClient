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

namespace alxmsl\Telegram\Bot\Type;

use alxmsl\Telegram\Bot\ObjectInitializedInterface;
use stdClass;

/**
 * Message representation class
 * @author alxmsl
 */
class Message implements ObjectInitializedInterface {
    /**
     * @var int Unique message identifier
     */
    private $messageId = 0;
    
    /**
     * @param int $messageId Unique message identifier
     * @return $this self instance
     */
    private function setMessageId($messageId) {
        $this->messageId = (int) $messageId;
        return $this;
    }
    
    /**
     * @return int Unique message identifier
     */
    public function getMessageId() {
        return $this->messageId;
    }
    
    /**
     * @var User Sender instance
     */
    private $From = null;
    
    /**
     * @param stdClass $From Sender instance
     * @return $this self instance
     */
    private function setFrom(stdClass $From) {
        $this->From = User::initializeByObject($From);
        return $this;
    }
    
    /**
     * @return User Sender instance
     */
    public function getFrom() {
        return $this->From;
    }
    
    /**
     * @var int date the message was sent in Unix time
     */
    private $date = 0;
    
    /**
     * @param int $date date the message was sent in Unix time
     * @return $this self instance
     */
    private function setDate($date) {
        $this->date = (int) $date;
        return $this;
    }
    
    /**
     * @return int date the message was sent in Unix time
     */
    public function getDate() {
        return $this->date;
    }
    
    /**
     * @var User|GroupChat conversation the message belongs to — user in case of a private $message, GroupChat in case of a group
     */
    private $Chat = null;
    
    /**
     * @param stdClass $Chat conversation the message belongs to — user in case of a private $message, GroupChat in case of a group
     * @return $this self instance
     */
    private function setChat(stdClass $Chat) {
        if (isset($Chat->title)) {
            $this->Chat = GroupChat::initializeByObject($Chat);
        } else {
            $this->Chat = User::initializeByObject($Chat);
        }
        return $this;
    }
    
    /**
     * @return User|GroupChat conversation the message belongs to — user in case of a private $message, GroupChat in case of a group
     */
    public function getChat() {
        return $this->Chat;
    }
    
    /**
     * @var User|null for forwarded messages, sender of the original message
     */
    private $ForwardFrom = null;
    
    /**
     * @param stdClass $ForwardFrom for forwarded messages, sender of the original message
     * @return $this self instance
     */
    private function setForwardFrom(stdClass $ForwardFrom) {
        $this->ForwardFrom = User::initializeByObject($ForwardFrom);
        return $this;
    }
    
    /**
     * @return User|null for forwarded messages, sender of the original message
     */
    public function getForwardFrom() {
        return $this->ForwardFrom;
    }
    
    /**
     * @var int for forwarded messages, date the original message was sent in Unix time
     */
    private $forwardDate = 0;
    
    /**
     * @param int $forwardDate for forwarded messages, date the original message was sent in Unix time
     * @return $this self instance
     */
    private function setForwardDate($forwardDate) {
        $this->forwardDate = (int) $forwardDate;
        return $this;
    }
    
    /**
     * @return int for forwarded messages, date the original message was sent in Unix time
     */
    public function getForwardDate() {
        return $this->forwardDate;
    }
    
    /**
     * @var Message|null for replies, the original message. Note that the Message object in this field will not contain 
     * further ReplyToMessage fields even if it itself is a reply.
     */
    private $ReplyToMessage = null;
    
    /**
     * @param stdClass $ReplyToMessage for replies, the original message. Note that the Message object in this field
     * will not contain further ReplyToMessage fields even if it itself is a reply.
     * @return $this self instance
     */
    private function setReplyToMessage(stdClass $ReplyToMessage) {
        $this->ReplyToMessage = Message::initializeByObject($ReplyToMessage);
        return $this;
    }
    
    /**
     * @return Message|null for replies, the original message. Note that the Message object in this field will not 
     * contain further ReplyToMessage fields even if it itself is a reply.
     */
    public function getReplyToMessage() {
        return $this->ReplyToMessage;
    }
    
    /**
     * @var string for text messages, the actual UTF-8 text of the message
     */
    private $text = '';
    
    /**
     * @param string $text for text messages, the actual UTF-8 text of the message
     * @return $this self instance
     */
    private function setText($text) {
        $this->text = (string) $text;
        return $this;
    }
    
    /**
     * @return string for text messages, the actual UTF-8 text of the message
     */
    public function getText() {
        return $this->text;
    }
    
    /**
     * @var Audio|null when message is an audio file, information about the file
     */
    private $Audio = null;
    
    /**
     * @param stdClass $Audio when message is an audio file, information about the file
     * @return $this self instance
     */
    private function setAudio($Audio) {
        $this->Audio = Audio::initializeByObject($Audio);
        return $this;
    }
    
    /**
     * @return Audio|null when message is an audio file, information about the file
     */
    public function getAudio() {
        return $this->Audio;
    }
    
    /**
     * @var Document|null when message is a general file, information about the file
     */
    private $Document = null;
    
    /**
     * @param stdClass $Document when message is a general file, information about the file
     * @return $this self instance
     */
    private function setDocument(stdClass $Document) {
        $this->Document = Document::initializeByObject($Document);
        return $this;
    }
    
    /**
     * @return Document|null when message is a general file, information about the file
     */
    public function getDocument() {
        return $this->Document;
    }
    
    /**
     * @var PhotoSize[]	when message is a photo, available sizes of the photo
     */
    private $photo = [];
    
    /**
     * @param stdClass[] $photo when message is a photo, available sizes of the photo
     * @return $this self instance
     */
    private function setPhoto($photo) {
        foreach ($photo as $size) {
            $this->photo[] = PhotoSize::initializeByObject($size);
        }
        return $this;
    }
    
    /**
     * @return PhotoSize[] when message is a photo, available sizes of the photo
     */
    public function getPhoto() {
        return $this->photo;
    }
    
    /**
     * @var Sticker|null when message is a sticker, information about the sticker
     */
    private $Sticker = null;
    
    /**
     * @param stdClass $Sticker when message is a sticker, information about the sticker
     * @return $this self instance
     */
    private function setSticker($Sticker) {
        $this->Sticker = Sticker::initializeByObject($Sticker);
        return $this;
    }
    
    /**
     * @return Sticker|null when message is a sticker, information about the sticker
     */
    public function getSticker() {
        return $this->Sticker;
    }
    
    /**
     * @var Video|null when message is a video, information about the video
     */
    private $Video = null;
    
    /**
     * @param stdClass $Video when message is a video, information about the video
     * @return $this self instance
     */
    private function setVideo(stdClass $Video) {
        $this->Video = Video::initializeByObject($Video);
        return $this;
    }
    
    /**
     * @return Video|null when message is a video, information about the video
     */
    public function getVideo() {
        return $this->Video;
    }
    
    /**
     * @var Contact|null when message is a shared contact, information about the contact
     */
    private $Contact = null;
    
    /**
     * @param stdClass $Contact when message is a shared contact, information about the contact
     * @return $this self instance
     */
    private function setContact(stdClass $Contact) {
        $this->Contact = Contact::initializeByObject($Contact);
        return $this;
    }
    
    /**
     * @return Contact|null when message is a shared contact, information about the contact
     */
    public function getContact() {
        return $this->Contact;
    }
    
    /**
     * @var Location|null when message is a shared location, information about the location
     */
    private $Location = null;
    
    /**
     * @param stdClass $Location when message is a shared location, information about the location
     * @return $this self instance
     */
    private function setLocation($Location) {
        $this->Location = Location::initializeByObject($Location);
        return $this;
    }
    
    /**
     * @return Location|null when message is a shared location, information about the location
     */
    public function getLocation() {
        return $this->Location;
    }
    
    /**
     * @var User|null a new member was added to the group, information about them ($this member may be bot itself)
     */
    private $NewChatParticipant = null;
    
    /**
     * @param stdClass $NewChatParticipant a new member was added to the group, information about them ($this member 
     * may be bot itself)
     * @return $this self instance
     */
    private function setNewChatParticipant(stdClass $NewChatParticipant) {
        $this->NewChatParticipant = User::initializeByObject($NewChatParticipant);
        return $this;
    }
    
    /**
     * @return User|null a new member was added to the group, information about them ($this member may be bot itself)
     */
    public function getNewChatParticipant() {
        return $this->NewChatParticipant;
    }
    
    /**
     * @var User|null a member was removed from the group, information about them ($this member may be bot itself)
     */
    private $LeftChatParticipant = '';
    
    /**
     * @param stdClass $LeftChatParticipant a member was removed from the group, information about them ($this member 
     * may be bot itself)
     * @return $this self instance
     */
    private function setLeftChatParticipant(stdClass $LeftChatParticipant) {
        $this->LeftChatParticipant = User::initializeByObject($LeftChatParticipant);
        return $this;
    }
    
    /**
     * @return User|null a member was removed from the group, information about them ($this member may be bot itself)
     */
    public function getLeftChatParticipant() {
        return $this->LeftChatParticipant;
    }
    
    /**
     * @var string a group title was changed to this value
     */
    private $newChatTitle = '';
    
    /**
     * @param string $newChatTitle a group title was changed to this value
     * @return $this self instance
     */
    private function setNewChatTitle($newChatTitle) {
        $this->newChatTitle = (string) $newChatTitle;
        return $this;
    }
    
    /**
     * @return string a group title was changed to this value
     */
    public function getNewChatTitle() {
        return $this->newChatTitle;
    }
    
    /**
     * @var PhotoSize[]	a group photo was change to this value
     */
    private $newChatPhoto = [];
    
    /**
     * @param stdClass[] $newChatPhoto a group photo was change to this value
     * @return $this self instance
     */
    private function setNewChatPhoto($newChatPhoto) {
        foreach ($newChatPhoto as $size) {
            $this->newChatPhoto[] = PhotoSize::initializeByObject($size);
        }
        return $this;
    }
    
    /**
     * @return PhotoSize[] a group photo was change to this value
     */
    public function getNewChatPhoto() {
        return $this->newChatPhoto;
    }
    
    /**
     * @var bool informs that the group photo was deleted
     */
    private $deleteChatPhoto = false;
    
    /**
     * @param bool $deleteChatPhoto informs that the group photo was deleted
     * @return $this self instance
     */
    private function setDeleteChatPhoto($deleteChatPhoto) {
        $this->deleteChatPhoto = (bool) $deleteChatPhoto;
        return $this;
    }
    
    /**
     * @return bool informs that the group photo was deleted
     */
    public function getDeleteChatPhoto() {
        return $this->deleteChatPhoto;
    }
    
    /**
     * @var bool informs that the group has been created
     */
    private $groupChatCreated = false;
    
    /**
     * @param bool $groupChatCreated informs that the group has been created
     * @return $this self instance
     */
    private function setGroupChatCreated($groupChatCreated) {
        $this->groupChatCreated = $groupChatCreated;
        return $this;
    }
    
    /**
     * @return bool informs that the group has been created
     */
    public function getGroupChatCreated() {
        return $this->groupChatCreated;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Message = new self();
        $Message->setMessageId($Object->message_id);
        $Message->setFrom($Object->from);
        $Message->setDate($Object->date);
        $Message->setChat($Object->chat);

        if (isset($Object->forward_from)) {
            $Message->setForwardFrom($Object->forward_from);
        }
        if (isset($Object->forward_date)) {
            $Message->setForwardDate($Object->forward_date);
        }
        if (isset($Object->reply_to_message)) {
            $Message->setReplyToMessage($Object->reply_to_message);
        }
        if (isset($Object->text)) {
            $Message->setText($Object->text);
        }
        if (isset($Object->audio)) {
            $Message->setAudio($Object->audio);
        }
        if (isset($Object->document)) {
            $Message->setDocument($Object->document);
        }
        if (isset($Object->photo)) {
            $Message->setPhoto($Object->photo);
        }
        if (isset($Object->sticker)) {
            $Message->setSticker($Object->sticker);
        }
        if (isset($Object->video)) {
            $Message->setVideo($Object->video);
        }
        if (isset($Object->contact)) {
            $Message->setContact($Object->contact);
        }
        if (isset($Object->location)) {
            $Message->setLocation($Object->location);
        }
        if (isset($Object->new_chat_participant)) {
            $Message->setNewChatParticipant($Object->new_chat_participant);
        }
        if (isset($Object->left_chat_participant)) {
            $Message->setLeftChatParticipant($Object->left_chat_participant);
        }
        if (isset($Object->new_chat_title)) {
            $Message->setNewChatTitle($Object->new_chat_title);
        }
        if (isset($Object->new_chat_photo)) {
            $Message->setNewChatPhoto($Object->new_chat_photo);
        }
        if (isset($Object->delete_chat_photo)) {
            $Message->setDeleteChatPhoto($Object->delete_chat_photo);
        }
        if (isset($Object->group_chat_created)) {
            $Message->setGroupChatCreated($Object->group_chat_created);
        }
        return $Message;
    }
}
